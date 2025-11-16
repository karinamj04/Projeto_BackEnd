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
  <title>Painel de Consultas - Raízes da Saúde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>
 
   <!-- Sidebar (mantida exatamente como estava) -->
  <div class="sidebar p-3">
    <h3 class="mb-4 fw-bold">Raiz Saúde </h3>
   <nav class="nav flex-column">

      <a href="admin.php" class="nav-link">
      <i class="bi bi-speedometer2 me-2"></i> Painel de Consultas
    </a>
      <a href="admin_cadastro.php">Cadastrar</a>
      <a href="criar_acesso.php">Criar Acesso</a>
      <a href="crud.php">Pacientes</a>
      <a href="consultas.php">Consultas</a>
      <a href="log.php">Relatórios</a>
      <a href="configuracoes.php" >Configurações</a>
      <a href="sistema.php" class="link-secondary link-offset-2 link-underline-opacity-25 link-opacity-100-hover">
      <i class="bi bi-person"></i> Sistema
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
        <img src="uploads/admin.png" alt="Foto do administrador" class="rounded-circle profile-pic" id="adminFoto">
      </div>
    </nav>
 
    <!-- Conteúdo -->
    <main class="p-4 flex-grow-1">
      <!-- Cards -->
      <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h6 class="text-muted">Total Pacientes</h6>
              <h3 class="fw-bold text-success">690</h3>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h6 class="text-muted">Consultas Agendadas</h6>
              <h3 class="fw-bold text-success">120</h3>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card shadow-sm border-0">
            <div class="card-body">
              <h6 class="text-muted">Consultas Realizadas</h6>
              <h3 class="fw-bold text-success">540</h3>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-lg-3">
          <div class="card shadow-sm card-highlight">
            <div class="card-body">
              <h6>Taxa de Satisfação</h6>
              <h3 class="fw-bold">85%</h3>
            </div>
          </div>
        </div>
      </div>

      <!-- Formulário -->
      <div class="card shadow-sm border-0">
        <div class="card-body">
          <h5 class="card-title mb-4 text-success">Agendamentos de Paciente</h5>
          <form id="formAgendamento" action="admin_processa_agendamento.php" method="POST">
      <!-- 🧍 Etapa 1 - Dados do paciente -->
      <div class="mb-3">
        <label class="form-label">Nome Completo:</label>
        <input type="text" name="nome" class="form-control" placeholder="Digite seu nome completo" required>
      </div>

      <div class="mb-3">
        <label class="form-label">CPF:</label>
        <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Telefone:</label>
        <input type="text" name="telefone" class="form-control" placeholder="(00) 00000-0000" required>
      </div>

      <div class="mb-3">
        <label class="form-label">E-mail:</label>
        <input type="email" name="email" class="form-control" placeholder="exemplo@dominio.com" required>
      </div>
      
      <!-- Etapa 2 - Dados da consulta -->
       <div class="mb-3">
        <label class="form-label">Especialidade:</label>
        <select name="especialidade" id="especialidade" class="form-select" required>
          <option value="">Selecione</option>
          <?php
          $sql = "SELECT * FROM especialidades";
          $result = $conn->query($sql);
          while ($row = $result->fetch_assoc()) {
            echo "<option value='{$row['id']}'>{$row['nome']}</option>";
          }
          ?>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Médico:</label>
        <select name="medico" id="medico" class="form-select" required>
          <option value="">Selecione a especialidade primeiro</option>
        </select>
      </div>

      <div class="mb-3">
        <label class="form-label">Data da Consulta:</label>
        <input type="date" name="data" class="form-control" required>
      </div>

      <div class="mb-4">
        <label class="form-label">Horário:</label>
        <select name="horario" id="horario" class="form-select" required>
          <option value="">Selecione o médico primeiro</option>
        </select>
      </div> 

      <div class="d-grid">
        <button type="submit" class="btn btn-success fw-bold py-2">Confirmar Agendamento</button>
      </div>
    </form>
        </div>
      </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Seus scripts que NÃO dependem do SweetAlert -->
<script src="js/admin.js"></script>
<script src="js/admin_agenda.js"></script>

<!-- Bootstrap Icons (está ok aqui) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

<!-- Carrega o SweetAlert2 ANTES de você usar Swal.fire -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById("formAgendamento").addEventListener("submit", function(e) {
    e.preventDefault(); // Impede o recarregamento da página

    const formData = new FormData(this);

    fetch("admin_processa_agendamento.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(retorno => {

        if (retorno.trim() === "sucesso") {

            Swal.fire({
                icon: "success",
                title: "Agendamento realizado!",
                text: "O paciente foi agendado com sucesso.",
                confirmButtonText: "Ok"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "consultas.php"; 
                }
            });

        }

        else if (retorno.trim() === "cpf_inexistente") {

            Swal.fire({
                icon: "error",
                title: "CPF não encontrado",
                text: "Esse paciente não está cadastrado.",
                showCancelButton: true,
                confirmButtonText: "Cadastrar",
                cancelButtonText: "Verificar"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "admin_cadastro.php"; // coloque aqui o nome correto da sua página
                }
            });

        }

        else {
            Swal.fire({
                icon: "error",
                title: "Erro!",
                text: "Não foi possível realizar o agendamento.",
                confirmButtonText: "Tentar novamente"
            });
        }

    });
});
</script>





</body>
</html>
