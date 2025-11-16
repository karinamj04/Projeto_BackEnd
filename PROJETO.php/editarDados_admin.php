<?php
session_start();
include('conexao.php'); // conexão com $conn

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT * FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();
}

// Se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $sobrenome = $_POST['sobrenome'] ?? '';
    $nomeMaterno = $_POST['nomeMaterno'] ?? '';
    $sexo = $_POST['sexo'] ?? '';
    $dataNascimento = $_POST['dataNascimento'] ?? '';
    $telefoneCelular = $_POST['telefoneCelular'] ?? '';
    $endereco = $_POST['endereco'] ?? '';
    $bairro = $_POST['bairro'] ?? '';
    $cidade = $_POST['cidade'] ?? '';
    $estado = $_POST['estado'] ?? '';
    $cep = $_POST['cep'] ?? '';

    $novaSenha = $_POST['nova_senha'] ?? '';
    $confirmaSenha = $_POST['confirma_senha'] ?? '';

    $senhaValida = true;
    $hashSenha = null;

    if (!empty($novaSenha)) {
        if ($novaSenha === $confirmaSenha) {
            $hashSenha = password_hash($novaSenha, PASSWORD_DEFAULT);
        } else {
            $senhaValida = false;
        }
    }

    if ($senhaValida) {
        if ($hashSenha) {
            $sql = "UPDATE usuarios SET nome=?, sobrenome=?, nomeMaterno=?, sexo=?, DataNascimento=?, telefoneCelular=?, endereco=?, bairro=?, cidade=?, estado=?, cep=?, senha=? WHERE email=?";
            $update = $conn->prepare($sql);
            $update->bind_param("sssssssssssss", $nome, $sobrenome, $nomeMaterno, $sexo, $dataNascimento, $telefoneCelular, $endereco, $bairro, $cidade, $estado, $cep, $hashSenha, $email);
        } else {
            $sql = "UPDATE usuarios SET nome=?, sobrenome=?, nomeMaterno=?, sexo=?, DataNascimento=?, telefoneCelular=?, endereco=?, bairro=?, cidade=?, estado=?, cep=? WHERE email=?";
            $update = $conn->prepare($sql);
            $update->bind_param("ssssssssssss", $nome, $sobrenome, $nomeMaterno, $sexo, $dataNascimento, $telefoneCelular, $endereco, $bairro, $cidade, $estado, $cep, $email);
        }

        $update->execute();
        header("Location: configuracoes.php?atualizado=1");
        exit();
    } else {
        $erroSenha = "As senhas não coincidem!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar dados - Raízes da Saúde </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .card {
      border-radius: 15px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      border: none;
      max-width: 850px;
      margin: auto;
    }
    .titulo {
      color: #1b8836;
      font-weight: 700;
    }
    .btn-salvar {
      background-color: #1b8836;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      transition: 0.3s;
    }
    .btn-salvar:hover {
      background-color: #157347;
    }
    .linha {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
    }
    .btn-voltar {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 1.3rem;
      color: #dc3545;
    }
  </style>
</head>
<body>

<div class="main-content">
  <div class="card p-4">
    <a href="configuracoes.php" class="btn btn-voltar" title="Voltar"><i class="bi bi-x-circle-fill"></i></a>
    <h2 class="text-center mb-4 titulo"></h2>

    <?php if (isset($erroSenha)): ?>
      <div class="alert alert-danger text-center"><?php echo $erroSenha; ?></div>
    <?php elseif (isset($_GET['atualizado'])): ?>
      <div class="alert alert-success text-center"> Dados atualizados com sucesso!</div>
    <?php endif; ?>

    <form method="POST">
      <div class="linha mb-3">
        <div>
          <label>Nome:</label>
          <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($admin['nome']); ?>" required>
        </div>
        <div>
          <label>Sobrenome:</label>
          <input type="text" name="sobrenome" class="form-control" value="<?php echo htmlspecialchars($admin['sobrenome']); ?>" required>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label>Nome Materno:</label>
          <input type="text" name="nomeMaterno" class="form-control" value="<?php echo htmlspecialchars($admin['nomeMaterno']); ?>">
        </div>
        <div>
          <label>Sexo:</label>
          <select name="sexo" class="form-select">
            <option value="Feminino" <?= ($admin['sexo'] == 'Feminino') ? 'selected' : '' ?>>Feminino</option>
            <option value="Masculino" <?= ($admin['sexo'] == 'Masculino') ? 'selected' : '' ?>>Masculino</option>
            <option value="Outro" <?= ($admin['sexo'] == 'Outro') ? 'selected' : '' ?>>Outro</option>
          </select>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label>Data de Nascimento:</label>
          <input type="date" name="dataNascimento" class="form-control" value="<?php echo htmlspecialchars($admin['DataNascimento']); ?>">
        </div>
        <div>
          <label>Telefone Celular:</label>
          <input type="text" name="telefoneCelular" id="telefone" class="form-control" value="<?php echo htmlspecialchars($admin['telefoneCelular']); ?>">
        </div>
      </div>

      <hr>
      <h5 class="text-success fw-bold">Endereço</h5>

      <div class="linha mb-3">
        <div>
          <label>CEP:</label>
          <input type="text" name="cep" id="cep" class="form-control" value="<?php echo htmlspecialchars($admin['cep']); ?>">
        </div>
        <div>
          <label>Endereço:</label>
          <input type="text" name="endereco" class="form-control" value="<?php echo htmlspecialchars($admin['endereco']); ?>">
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label>Bairro:</label>
          <input type="text" name="bairro" id="bairro" class="form-control" value="<?php echo htmlspecialchars($admin['bairro']); ?>">
        </div>
        <div>
          <label>Cidade:</label>
          <input type="text" name="cidade" id="cidade" class="form-control" value="<?php echo htmlspecialchars($admin['cidade']); ?>">
        </div>
        <div>
          <label>Estado:</label>
          <input type="text" name="estado" id="uf" class="form-control" value="<?php echo htmlspecialchars($admin['estado']); ?>">
        </div>
      </div>

      <hr>
      <h5 class="text-success fw-bold">Trocar Senha</h5>

      <div class="linha mb-3">
        <div class="input-group">
          <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Digite nova senha">
          <span class="input-group-text" id="toggleNova"><i class="bi bi-eye"></i></span>
        </div>
        <div class="input-group">
          <input type="password" name="confirma_senha" id="confirma_senha" class="form-control" placeholder="Confirme a nova senha">
          <span class="input-group-text" id="toggleConfirma"><i class="bi bi-eye"></i></span>
        </div>
      </div>

      <div class="mt-4 d-grid">
        <button type="submit" class="btn btn-salvar">Salvar Alterações</button>
      </div>
    </form>
  </div>
</div>

<script>
  // Mostrar/ocultar senha
  const toggleNova = document.getElementById('toggleNova');
  const novaSenha = document.getElementById('nova_senha');
  toggleNova.addEventListener('click', () => {
    const type = novaSenha.type === 'password' ? 'text' : 'password';
    novaSenha.type = type;
    toggleNova.querySelector('i').classList.toggle('bi-eye');
    toggleNova.querySelector('i').classList.toggle('bi-eye-slash');
  });

  const toggleConfirma = document.getElementById('toggleConfirma');
  const confirmaSenha = document.getElementById('confirma_senha');
  toggleConfirma.addEventListener('click', () => {
    const type = confirmaSenha.type === 'password' ? 'text' : 'password';
    confirmaSenha.type = type;
    toggleConfirma.querySelector('i').classList.toggle('bi-eye');
    toggleConfirma.querySelector('i').classList.toggle('bi-eye-slash');
  });

  // Máscaras e busca CEP
  document.getElementById('telefone').addEventListener('input', e => {
    e.target.value = e.target.value.replace(/\D/g, '')
      .replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
  });

  document.getElementById('cep').addEventListener('focusout', function() {
    const raw = this.value.replace(/\D/g, '');
    if (raw.length === 8) {
      fetch('https://viacep.com.br/ws/' + raw + '/json/')
        .then(r => r.json())
        .then(data => {
          if (!data.erro) {
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('uf').value = data.uf || '';
          }
        });
    }
  });
</script>
</body>
</html>
