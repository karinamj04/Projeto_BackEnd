<?php
session_start();
include('conexao.php'); // conexão $conn

// --- Helpers de normalização ---
function remove_accents($str) {
    $map = [
        'Á'=>'A','À'=>'A','Â'=>'A','Ã'=>'A','Ä'=>'A',
        'á'=>'a','à'=>'a','â'=>'a','ã'=>'a','ä'=>'a',
        'É'=>'E','È'=>'E','Ê'=>'E','Ë'=>'E',
        'é'=>'e','è'=>'e','ê'=>'e','ë'=>'e',
        'Í'=>'I','Ì'=>'I','Î'=>'I','Ï'=>'I',
        'í'=>'i','ì'=>'i','î'=>'i','ï'=>'i',
        'Ó'=>'O','Ò'=>'O','Ô'=>'O','Õ'=>'O','Ö'=>'O',
        'ó'=>'o','ò'=>'o','ô'=>'o','õ'=>'o','ö'=>'o',
        'Ú'=>'U','Ù'=>'U','Û'=>'U','Ü'=>'U',
        'ú'=>'u','ù'=>'u','û'=>'u','ü'=>'u',
        'Ç'=>'C','ç'=>'c','Ñ'=>'N','ñ'=>'n'
    ];
    return strtr($str, $map);
}

function normalize_name($s) {
    $s = trim(mb_strtolower($s, 'UTF-8'));
    $s = preg_replace('/\s+/', ' ', $s);
    $s = remove_accents($s);
    return $s;
}

function normalize_cep_to_db_format($s) {
    $digits = preg_replace('/\D+/', '', $s);
    if(strlen($digits) === 8) {
        return substr($digits,0,5) . '-' . substr($digits,5);
    }
    return $digits;
}

function normalize_date_to_db_format($s) {
    $s = trim($s);
    if ($s === '') return '';

    $formats = ['d/m/Y', 'd-m-Y', 'Y-m-d', 'Y/m/d', 'Ymd', 'dmY'];
    foreach($formats as $fmt) {
        $d = DateTime::createFromFormat($fmt, $s);
        if($d) return $d->format('Y-m-d');
    }

    $digits = preg_replace('/\D+/', '', $s);
    if(strlen($digits) === 8) {
        $d = DateTime::createFromFormat('dmY', $digits);
        if($d) return $d->format('Y-m-d');
    }

    return $s;
}
// --- Fim helpers ---

// Verifica sessão temporária (definida no login)
if(!isset($_SESSION['email_temp'])) {
    header('Location: login.php');
    exit();
}

// Busca os dados do usuário (agora incluindo CPF e email)
$email_safe = mysqli_real_escape_string($conn, $_SESSION['email_temp']);
$sql = "SELECT cpf, email, nome, nomeMaterno, DataNascimento, cep, tipo 
        FROM usuarios 
        WHERE email = '$email_safe' 
        LIMIT 1";
$res = mysqli_query($conn, $sql);

if(!$res || mysqli_num_rows($res) !== 1) {
    session_destroy();
    header('Location: login.php');
    exit();
}

$usuario = mysqli_fetch_assoc($res);

// Mapeia perguntas e respostas corretas
$respostasCorretas = [
    "Qual o nome da sua mãe?" => $usuario['nomeMaterno'] ?? '',
    "Qual a data do seu nascimento?" => $usuario['DataNascimento'] ?? '',
    "Qual o CEP do seu endereço?" => $usuario['cep'] ?? ''
];

// Seleciona pergunta aleatória
if(!isset($_SESSION['pergunta_2fa'])) {
    $perguntas = array_keys($respostasCorretas);
    $_SESSION['pergunta_2fa'] = $perguntas[array_rand($perguntas)];
}

// Inicializa tentativas
if(!isset($_SESSION['tentativas_2fa'])) {
    $_SESSION['tentativas_2fa'] = 0;
}

$erro2fa = "";

// --- Quando o formulário é enviado ---
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entrada = trim($_POST['codigo2fa'] ?? '');
    $perguntaAtual = $_SESSION['pergunta_2fa'];
    $respostaBanco = $respostasCorretas[$perguntaAtual];
    $is_correct = false;

    if($perguntaAtual === "Qual o nome da sua mãe?") {
        $entrada_norm = normalize_name($entrada);
        $banco_norm = normalize_name($respostaBanco);
        if($entrada_norm !== '' && $entrada_norm === $banco_norm) $is_correct = true;

    } elseif($perguntaAtual === "Qual a data do seu nascimento?") {
        $entrada_norm = normalize_date_to_db_format($entrada);
        $banco_norm = $respostaBanco;
        if($entrada_norm !== '' && $entrada_norm === $banco_norm) $is_correct = true;

    } elseif($perguntaAtual === "Qual o CEP do seu endereço?") {
        $entrada_norm = normalize_cep_to_db_format($entrada);
        $banco_norm = normalize_cep_to_db_format($respostaBanco);
        if($entrada_norm !== '' && $entrada_norm === $banco_norm) $is_correct = true;
    }

    // --- Inserção no log ---
    $cpf = $usuario['cpf'];
    $email = $usuario['email'];
    $segundo_fator = $perguntaAtual;
    $status = $is_correct ? 'sucesso' : 'falha';

    $sqlLog = "INSERT INTO logs_autenticacao (cpf, email, segundo_fator, status)
               VALUES ('$cpf', '$email', '$segundo_fator', '$status')";
    mysqli_query($conn, $sqlLog);

    // --- Pós-verificação ---
    if($is_correct) {
        // Login bem-sucedido
        $_SESSION['email'] = $_SESSION['email_temp'];
        $_SESSION['nome']  = $_SESSION['nome_temp'] ?? $usuario['nome'] ?? '';
        $_SESSION['tipo']  = $usuario['tipo'] ?? 'paciente';

        unset($_SESSION['email_temp'], $_SESSION['nome_temp'], $_SESSION['pergunta_2fa'], $_SESSION['tentativas_2fa']);

        if($_SESSION['tipo'] === 'admin') {
            header('Location: admin.php');
        } elseif($_SESSION['tipo'] === 'recepcionista') {
            header('Location: recepcionista.php');
        } else {
            header('Location: sistema.php');
        }
        exit();
    } else {
        $_SESSION['tentativas_2fa']++;
        if($_SESSION['tentativas_2fa'] >= 3) {
            session_destroy();
            header('Location: cadastro.php');
            exit();
        } else {
            $erro2fa = "Resposta incorreta. Tentativa {$_SESSION['tentativas_2fa']}/3.";
            $perguntas = array_keys($respostasCorretas);
            $possiveis = array_diff($perguntas, [$_SESSION['pergunta_2fa']]);
            if(!empty($possiveis)) {
                $_SESSION['pergunta_2fa'] = $possiveis[array_rand($possiveis)];
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Autenticação de 2 Fatores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/2fa.css">
  <style>
    .btn-verde { background:#2a9d8f; color:#fff; border:none; padding:.5rem 1rem; border-radius:.35rem; }
  </style>
</head>
<body>
<header class="text-center my-4">
    <h1>Verificação de Segurança</h1>
</header>

<main class="container">
    <h2 id="pergunta"><?php echo htmlspecialchars($_SESSION['pergunta_2fa'], ENT_QUOTES, 'UTF-8'); ?></h2>

    <?php if($erro2fa): ?>
      <div class="alert alert-danger"><?php echo htmlspecialchars($erro2fa, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

    <form id="form2fa" method="POST" action="2fa.php" class="mb-3">
      <div class="mb-3">
        <input type="text" name="codigo2fa" id="resposta" class="form-control" placeholder="Digite sua resposta" required />
      </div>
      <button type="submit" class="btn-verde">Enviar</button>
    </form>

    <p class="text-muted">
      Dica: responda exatamente como consta no seu cadastro.
    </p>
</main>

<footer class="text-center mt-5">
    <div class="footer-container">
      <p>© 2025 Raízes da Saúde. Todos os direitos reservados.</p>
    </div>
</footer>
<div class="imagem-fundo">
    <img src="img/fundo.jpg" alt="Imagem de fundo" class="img-fluid w-100" />
  </div>
<script>
const form = document.getElementById('form2fa');
const resposta = document.getElementById('resposta');
form.addEventListener('submit', function(e){
    if(resposta.value.trim() === ''){
        e.preventDefault();
        alert('Por favor, preencha a resposta.');
    }
});

// --------------------------
// MÁSCARA DE DATA (DD/MM/YYYY)
// --------------------------
function aplicarMascaraData(input) {
    input.addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 2 && v.length <= 4) {
            e.target.value = v.slice(0, 2) + '/' + v.slice(2);
        } else if (v.length > 4) {
            e.target.value = v.slice(0, 2) + '/' + v.slice(2, 4) + '/' + v.slice(4, 8);
        } else {
            e.target.value = v;
        }
    });
}

function aplicarMascaraCEP(input) {
    input.addEventListener('input', function(e) {
        let v = e.target.value.replace(/\D/g, '');
        if (v.length > 5) {
            e.target.value = v.slice(0,5) + '-' + v.slice(5,8);
        } else {
            e.target.value = v;
        }
    });
}

const pergunta = document.getElementById('pergunta').innerText.trim();
const campoResposta = document.getElementById('resposta');
if (pergunta === "Qual a data do seu nascimento?") aplicarMascaraData(campoResposta);
if (pergunta === "Qual o CEP do seu endereço?") aplicarMascaraCEP(campoResposta);
</script>
</body>
</html>
