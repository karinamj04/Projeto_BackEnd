<?php
session_start();
include 'conexao.php';

// ⚙️ Verifica se o paciente está logado
if (!isset($_SESSION['email'])) {
  header("Location: login.php");
  exit();
}

$email = $_SESSION['email'];
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$result = $conn->query($sql);
$usuario = $result->fetch_assoc();

// ✅ Atualiza os dados quando o formulário é enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nome = $_POST['nome'];
  $sobrenome = $_POST['sobrenome'];
  $nomeMaterno = $_POST['nomeMaterno'];
  $sexo = $_POST['sexo'];
  $endereco = $_POST['endereco'];
  $bairro = $_POST['bairro'];
  $cidade = $_POST['cidade'];
  $estado = $_POST['estado'];
  $cep = $_POST['cep'];
  $telefoneCelular = $_POST['telefoneCelular'];
  $dataNascimento = $_POST['DataNascimento'];

  $senhaValida = true;
  $hashSenha = null;

  // Verifica se o paciente digitou uma nova senha
  if (!empty($_POST['nova_senha'])) {
      if ($_POST['nova_senha'] === $_POST['confirma_senha']) {
          $hashSenha = password_hash($_POST['nova_senha'], PASSWORD_DEFAULT);
      } else {
          $senhaValida = false;
      }
  }

  if ($senhaValida) {
      if ($hashSenha) {
          $update = $conn->prepare("UPDATE usuarios SET 
            nome=?, sobrenome=?, nomeMaterno=?, sexo=?, endereco=?, bairro=?, cidade=?, estado=?, cep=?, telefoneCelular=?, DataNascimento=?, senha=?
            WHERE email=?");
          $update->bind_param("sssssssssssss", $nome, $sobrenome, $nomeMaterno, $sexo, $endereco, $bairro, $cidade, $estado, $cep, $telefoneCelular, $dataNascimento, $hashSenha, $email);
      } else {
          $update = $conn->prepare("UPDATE usuarios SET 
            nome=?, sobrenome=?, nomeMaterno=?, sexo=?, endereco=?, bairro=?, cidade=?, estado=?, cep=?, telefoneCelular=?, DataNascimento=?
            WHERE email=?");
          $update->bind_param("ssssssssssss", $nome, $sobrenome, $nomeMaterno, $sexo, $endereco, $bairro, $cidade, $estado, $cep, $telefoneCelular, $dataNascimento, $email);
      }

      $update->execute();
      header("Location: perfil.php?atualizado=1");
      exit();
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Editar Dados Pacientes - Raízes da Saúde </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    body { 
    background-color: #f8f9fa; 
    font-family: 'Poppins', sans-serif;
}
    .card {
    border-radius: 15px; 
    box-shadow: 0 4px 10px rgba(0,0,0,0.1); 
    border: none; 
    max-width: 800px; 
    margin: auto;
}
    .titulo { 
    color: #1b8836; 
    font-weight: 700; 
}
    label { 
    font-weight: 600; 
    color: #495057; 
    margin-top: 8px; 
}
    input, select { 
    border-radius: 8px !important; 
    border: 1px solid #dee2e6 !important; 
    padding: 10px; 
}
    .btn-salvar { 
    background-color: #1b8836; 
    color: white; font-weight: 600; 
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
    .alerta-sucesso { 
    background-color: #d1e7dd; 
    color: #0f5132; 
    border-radius: 10px; 
    padding: 10px; 
    text-align: center; 
    margin-bottom: 20px; 
    font-weight: 500; 
    display: none; 
}
    .alerta-erro { 
    background-color: #f8d7da; 
    color: #842029; 
    border-radius: 10px; 
    padding: 10px;
    margin-bottom: 10px; 
    font-weight: 500; 
    display: none;
}
    .btn-voltar {
     position: absolute; 
     top: 15px; 
     right: 15px; 
     font-size: 1.3rem; 
     color: #dc3545; 
}
  .senha-container {
  position: relative;
}

.senha-container input {
  padding-right: 50px; /* espaço para o ícone não sobrepor o texto */
}

.senha-container i {
  position: absolute;
  right: 12px;         /* distância da borda direita */
  top: 50%;            /* centraliza verticalmente */
  transform: translateY(10%);
  cursor: pointer;
  color: #495057;
  font-size: 1.2rem;   /* tamanho do ícone */
}

  </style>
</head>
<body>

<div class="container mt-5">
  <div class="card p-4">
    <a href="sistema.php" class="btn btn-voltar" title="Voltar"><i class="bi bi-x-circle-fill"></i></a>
    <h2 class="text-center mb-4 titulo">Editar Dados do Paciente</h2>

  
    <div id="erroSenha" class="alerta-erro">❌ As senhas não coincidem!</div>

    <form method="POST" id="formEdicao">

      <!-- Dados pessoais -->
      <div class="linha">
        <div>
          <label>Nome:</label>
          <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
        </div>
        <div>
          <label>Sobrenome:</label>
          <input type="text" name="sobrenome" class="form-control" value="<?= htmlspecialchars($usuario['sobrenome']) ?>">
        </div>
      </div>

      <div class="linha">
        <div>
          <label>Nome Materno:</label>
          <input type="text" name="nomeMaterno" class="form-control" value="<?= htmlspecialchars($usuario['nomeMaterno']) ?>">
        </div>
        <div>
          <label>Sexo:</label>
          <select name="sexo" class="form-select">
            <option value="Feminino" <?= $usuario['sexo']=='Feminino'?'selected':'' ?>>Feminino</option>
            <option value="Masculino" <?= $usuario['sexo']=='Masculino'?'selected':'' ?>>Masculino</option>
            <option value="Outro" <?= $usuario['sexo']=='Outro'?'selected':'' ?>>Outro</option>
          </select>
        </div>
      </div>

      <div class="linha">
        <div>
          <label>Data de Nascimento:</label>
          <input type="date" name="DataNascimento" class="form-control" value="<?= htmlspecialchars($usuario['DataNascimento']) ?>">
        </div>
        <div>
          <label>Telefone Celular:</label>
          <input type="text" name="telefoneCelular" id="telefone" class="form-control" value="<?= htmlspecialchars($usuario['telefoneCelular']) ?>">
        </div>
      </div><br>

      
      <hr>

      <!-- Senha -->
      <h5 class="text-success fw-bold mb-3 text-start">Senha</h5>
      <div class="linha">
        <div class="senha-container">
          <label>Nova Senha:</label>
          <input type="password" name="nova_senha" id="nova_senha" class="form-control" placeholder="Digite nova senha">
          <i class="bi bi-eye" id="toggleNova"></i>
        </div>
        <div class="senha-container">
          <label>Confirmar Senha:</label>
          <input type="password" name="confirma_senha" id="confirma_senha" class="form-control" placeholder="Confirme a nova senha">
          <i class="bi bi-eye" id="toggleConfirma"></i>
        </div>
      </div><br>


      <hr>

      <!-- Endereço -->
      <h5 class="text-success fw-bold mb-3 text-start">Endereço</h5>
      <div class="linha">
        <div>
          <label>CEP:</label>
          <input type="text" name="cep" id="cep" class="form-control" value="<?= htmlspecialchars($usuario['cep']) ?>">
        </div>
        <div>
          <label>Endereço:</label>
          <input type="text" name="endereco" id="rua" class="form-control" value="<?= htmlspecialchars($usuario['endereco']) ?>">
        </div>
      </div>

      <div class="linha">
        <div>
          <label>Bairro:</label>
          <input type="text" name="bairro" id="bairro" class="form-control" value="<?= htmlspecialchars($usuario['bairro']) ?>">
        </div>
        <div>
          <label>Cidade:</label>
          <input type="text" name="cidade" id="cidade" class="form-control" value="<?= htmlspecialchars($usuario['cidade']) ?>">
        </div>
      </div>

      <div class="linha">
        <div>
          <label>Estado:</label>
          <input type="text" name="estado" id="uf" class="form-control" value="<?= htmlspecialchars($usuario['estado']) ?>">
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
    toggleNova.classList.toggle('bi-eye');
    toggleNova.classList.toggle('bi-eye-slash');
  });

  const toggleConfirma = document.getElementById('toggleConfirma');
  const confirmaSenha = document.getElementById('confirma_senha');
  toggleConfirma.addEventListener('click', () => {
    const type = confirmaSenha.type === 'password' ? 'text' : 'password';
    confirmaSenha.type = type;
    toggleConfirma.classList.toggle('bi-eye');
    toggleConfirma.classList.toggle('bi-eye-slash');
  });

  // Verifica se as senhas coincidem em tempo real
  const form = document.getElementById('formEdicao');
  const erroSenha = document.getElementById('erroSenha');
  form.addEventListener('submit', (e) => {
    if(novaSenha.value !== confirmaSenha.value){
      e.preventDefault();
      erroSenha.style.display = 'block';
      setTimeout(()=> erroSenha.style.display='none',4000);
    }
  });

  // API de CEP
  document.getElementById('cep').addEventListener('focusout', function () {
    const raw = this.value.replace(/\D/g, '');
    if (raw.length === 8) {
      fetch('https://viacep.com.br/ws/' + raw + '/json/')
        .then(r => r.json())
        .then(data => {
          if (!data.erro) {
            document.getElementById('rua').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('uf').value = data.uf || '';
          }
        });
    };
  });

  // Máscaras de entrada
  document.getElementById('telefone').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '')
      .replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3');
  });

  document.getElementById('cep').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '')
      .replace(/(\d{5})(\d{3})/, '$1-$2');
  });
</script>

</body>
</html>
