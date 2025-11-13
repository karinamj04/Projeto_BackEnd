<?php
session_start();
include('conexao.php'); // conexão com $conn

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$email = $_SESSION['email'];
$query = "SELECT cpf, nome, sobrenome, sexo, email, DataNascimento, nomeMaterno, telefoneCelular, endereco, cep, bairro, cidade, estado, senha FROM usuarios WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $admin = $result->fetch_assoc();

    // Definindo variáveis
    $adminNome = $admin['nome'] ?? 'Não informado';
    $adminSobrenome = $admin['sobrenome'] ?? 'Não informado'; // pode não existir, cuidado
    $adminSexo = $admin['sexo'] ?? 'Não informado'; 
    $adminNascimento = $admin['DataNascimento'] ?? 'Não informado';
    $adminMaterno = $admin['nomeMaterno'] ?? 'Não informado';
    $adminTelefone = $admin['telefoneCelular'] ?? 'Não informado';
    $adminEndereco = $admin['endereco'] ?? 'Não informado';

    $adminBairro = $admin['bairro'] ?? 'Não informado';
    $adminCidade = $admin['cidade'] ?? 'Não informado';
    $adminEstado =$admin['estado'] ?? 'Não informado';
    $adminCEP = $admin['cep'] ?? 'Não informado';
    $adminCPF =  $admin['cpf'] ?? 'Não informado';

    $adminEmail = $admin['email'] ?? 'Não informado';

    // Como você não tem foto no banco, use a padrão:
    $adminFoto = 'uploads/default.png';
} else {
    // Caso não encontre o admin no DB
    $adminNome = $adminSobrenome = $adminMaterno = $adminTelefone = $adminEndereco = $adminBairro = $adminCidade = $adminEstado = $adminCEP = $adminSexo = $adminCPF = $adminEmail = "Não informado";
    $adminFoto = 'uploads/default.png';
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Configurações do Administrador - Raízes da Saúde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <link rel="stylesheet" href="css/admin.css">
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
    .profile-pic {
      width: 40px;
      height: 40px;
      object-fit: cover;
    }
  </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar p-3">
  <h3 class="mb-4 fw-bold">Raiz Saúde</h3>
  <nav class="nav flex-column">
    <a href="admin.php">Painel de Consultas</a>
    <a href="admin_cadastro.php">Cadastrar</a>
    <a href="criar_acesso.php">Criar Acesso</a>
    <a href="crud.php">Pacientes</a>
    <a href="consultas.php">Consultas</a>
    <a href="log.php">Relatórios</a>
    <a href="configuracoes.php" class="nav-link">
      <i class="bi bi-gear me-2"></i> Configurações
    </a>
    <a href="logout.php" class="nav-link text-danger">
      <i class="bi bi-box-arrow-right me-2"></i> Sair
    </a>
  </nav>
</div>

<!-- Main -->
<div class="flex-grow-1 d-flex flex-column">

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
    <div class="ms-auto d-flex align-items-center">
      <span class="me-2 fw-semibold text-success">
        Bem-vindo(a), <?php echo htmlspecialchars($adminNome); ?>!
      </span>
      <img src="<?php echo htmlspecialchars($adminFoto); ?>" alt="Foto do administrador" class="rounded-circle profile-pic" id="adminFoto">
    </div>
  </nav>

  <div class="container mt-5">
    <div class="card p-4">
      <h2 class="text-center mb-4 titulo">Ficha do Administrador</h2>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Nome:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminNome); ?></div>
        </div>
        <div>
          <label class="info-label">Sobrenome:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminSobrenome); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Nome Materno:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminMaterno); ?></div>
        </div>
        <div>
          <label class="info-label">Sexo:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminSexo); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Data de Nascimento:</label>
          <div class="info-box">
            <?php echo $adminNascimento !== 'Não informado' ? date('d/m/Y', strtotime($adminNascimento)) : 'Não informado'; ?>
          </div>
        </div>
        <div>
          <label class="info-label">CPF:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminCPF); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">E-mail:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminEmail); ?></div>
        </div>
        <div>
          <label class="info-label">Telefone Celular:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminTelefone); ?></div>
        </div>
      </div>

      <hr>

      <h5 class="text-success fw-bold mb-3 text-start">Endereço</h5>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Logradouro:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminEndereco); ?></div>
        </div>
        <div>
          <label class="info-label">Bairro:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminBairro); ?></div>
        </div>
      </div>

      <div class="linha mb-3">
        <div>
          <label class="info-label">Cidade:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminCidade); ?></div>
        </div>
        <div>
          <label class="info-label">Estado:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminEstado); ?></div>
        </div>
      </div>

      <div class="linha mb-4">
        <div>
          <label class="info-label">CEP:</label>
          <div class="info-box"><?php echo htmlspecialchars($adminCEP); ?></div>
        </div>
      </div>

      <!-- Alterar foto -->
          <div class="mb-3">
            <label class="form-label">Alterar Foto de Perfil</label>
            <input type="file" class="form-control" id="fotoInput" accept="image/*">
          </div>

      <div class="mt-4 d-grid">
        <a href="editardados_admin.php" class="btn btn-editar">Editar Informações</a>
      </div>

    </div>
  </div>

</div>

<script src="js/admin.js"></script>
</body>
</html>
