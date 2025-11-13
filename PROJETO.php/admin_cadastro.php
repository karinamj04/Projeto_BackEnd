<?php
session_start();
include('conexao.php'); // conexão padrão com $conn

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Pega o nome e e-mail direto da sessão (sem consulta)
$adminNome = $_SESSION['nome'] ?? 'Administrador';
$adminEmail = $_SESSION['email'] ?? 'sem_email@dominio.com';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar Paciente - Raízes da Saúde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body>

   <!-- Sidebar-->
  <div class="sidebar p-3">
    <h3 class="mb-4 fw-bold">Raiz Saúde   </h3>
    <nav class="nav flex-column">

      <a href="admin.php">Painel de Consultas</a>
     <a href="admin_cadastro.php" class="nav-link">
      <i class="bi bi-person-plus me-2"></i> Cadastrar
    </a>

      <a href="criar_acesso.php">Criar Acesso</a>
      <a href="crud.php">Pacientes</a>
      <a href="consultas.php">Consultas</a>
      <a href="log.php">Relatórios</a>
      <a href="configuracoes.php" >Configurações</a>
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
        <img src="uploads/admin.jpg" alt="Foto do administrador" class="rounded-circle profile-pic" id="adminFoto">
      </div>
    </nav>

    <div class='container mt-5'>
      <div class='row'>
        <div class= 'col-md-12'>
          <div class='card'>
            <div class='card-header'>
              <h4>Cadastrar Paciente
                <a href='crud.php' class='btn btn-danger float-end'>VOLTAR</a>
              </h4>
            </div>
            <div class='card-body'>
              <form action="acoes.php" method="POST">
                <div class="mb-3">
                  <label>CPF</label>
                 <input type="text" id="idCpf" class="form-control" name="cpf" maxlength="14" required>

                </div> 
                <div class="mb-3">
                  <label>Nome</label>
                  <input type="text" name="nome" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Sobrenome</label>
                  <input type="text" name="sobrenome" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Nome Materno</label>
                  <input type="text" name="nomeMaterno" class="form-control">
                </div>
                       <div class="col-md-6 mb-3">
          <label for="sexo" class="form-label">Sexo</label>
          <select class="form-select" id="sexo" name="sexo" required>
            <option disabled selected value="">Selecione</option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outros</option>
            <option value="P">Prefiro não responder</option>
          </select>
        </div>

         <div class="mb-3">
                  <label>CEP</label>
                  <input type="text" id="cep" name="cep" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Endereco</label>
                  <input type="text" id="rua"  name="endereco" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Bairro</label>
                  <input type="text" id="bairro" name="bairro" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Estado</label>
                  <input type="text" id="uf" name="estado" class="form-control">
                </div>
               
                <div class="mb-3">
                  <label>Cidade</label>
                  <input type="text" id="cidade" name="cidade" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Email</label>
                  <input type="text" name="email" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Data de Nascimento</label>
                  <input type="date" name="DataNascimento" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Telefone Celular</label>
                  <input type="text" id="telefone" name="telefoneCelular" class="form-control">
                </div>
                <div class="mb-3">
                  <button type="submit" name="create_usuario" class="btn btn-primary">Salvar</button>
                </div>
              </form>
            </div>
        </div>
        </div>
      </div>

    </div>
    
    <script src="js/admin_cadastro.js"></script>
    <script src="js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
