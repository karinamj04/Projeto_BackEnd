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
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Ficha do Paciente - - Raízes da Saúde</title>
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
      max-width: 800px;
      margin: auto;
    }

    .titulo {
      color: #1b8836;
      font-weight: 700;
    }

    .info-label {
      font-weight: 600;
      color: #495057;
      margin-bottom: 3px;
    }

    .info-box {
      background-color: #f1f3f5;
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid #dee2e6;
      font-size: 15px;
      color: #212529;
    }

    .btn-editar {
      background-color: #1b8836;
      color: white;
      font-weight: 600;
      border-radius: 8px;
      transition: 0.3s;
    }

    .btn-editar:hover {
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
  <div class="container mt-5">
    <div class="card p-4">
       <!-- Botão de voltar -->
      <a href="sistema.php" class="btn btn-voltar" title="Voltar"><i class="bi bi-x-circle-fill"></i></a>
      <h2 class="text-center mb-4 titulo">Ficha do Paciente</h2>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Nome:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['nome']); ?></div>
        </div>
        <div>
          <label class="info-label">Sobrenome:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['sobrenome']); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Nome Materno:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['nomeMaterno']); ?></div>
        </div>
        <div>
          <label class="info-label">Sexo:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['sexo']); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Data de Nascimento:</label>
          <div class="info-box">
            <?php echo date('d/m/Y', strtotime($usuario['DataNascimento'])); ?>
          </div>
        </div>
        <div>
          <label class="info-label">CPF:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['cpf']); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">E-mail:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['email']); ?></div>
        </div>
        <div>
          <label class="info-label">Telefone Celular:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['telefoneCelular']); ?></div>
        </div>
      </div>

      <hr>

      <h5 class="text-success fw-bold mb-3 text-start">Endereço</h5>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Logradouro:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['endereco']); ?></div>
        </div>
        <div>
          <label class="info-label">Bairro:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['bairro']); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Cidade:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['cidade']); ?></div>
        </div>
        <div>
          <label class="info-label">Estado:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['estado']); ?></div>
        </div>
      </div>

      <div class="linha mb-4">
        <div>
          <label class="info-label">CEP:</label>
          <div class="info-box"><?php echo htmlspecialchars($usuario['cep']); ?></div>
        </div>
      </div>

      <div class="mt-4 d-grid">
        <a href="editar_dados.php" class="btn btn-editar">Editar Informações</a>
      </div>
    </div>
  </div>
</body>
</html>
