<?php
session_start();
include("conexao.php");

// Verifica se o usuário realmente passou pelo login + 2FA
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

// Armazena o nome do usuário para exibir
$nomeUsuario = $_SESSION['nome'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sistema - Raízes da Saúde  </title>
  <link rel="stylesheet" href="css/sistema.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
   <script type="text/javascript" src="js/darkmode.js" defer></script>
</head>

<body>

<!--  NAVBAR -->
<header class="navbar navbar-expand-lg">
  <div class="container-fluid">
    <h1 class="logo">Raízes da Saúde</h1>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="contato.php">Contato</a></li>
      </ul>

      <!-- Botão modo escuro -->
      <button id="ModoEscuro">
        <i class="bi bi-moon-fill"></i>
        <i class="bi bi-brightness-high-fill"></i>
      </button>

     <!-- Dropdown do perfil -->
<div class="dropdown">
  <button class="btn dropdown-toggle" id="perfil-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="bi bi-person-circle me-1"></i> Perfil
  </button>
  <ul class="dropdown-menu dropdown-menu-end" id="perfil-menu">

    <li><a class="dropdown-item" href="perfil.php">
      <i class="bi bi-person-lines-fill me-2"></i> Ver Perfil
    </a></li>

    <li><a class="dropdown-item" href="historico.php">
      <i class="bi bi-calendar-check me-2"></i> Meus Agendamentos
    </a></li>

    <li><a class="dropdown-item" href="editar_dados.php">
      <i class="bi bi-pencil-square me-2"></i> Editar Dados
    </a></li>

    <li><hr class="dropdown-divider"></li>

    <!-- 🔥 ITEM EXCLUSIVO PARA ADMINISTRADORES -->
    <?php if (isset($_SESSION['tipo']) && $_SESSION['tipo'] === 'admin'): ?>
      <li>
        <a class="dropdown-item text-primary fw-semibold" href="admin.php">
          <i class="bi bi-speedometer2 me-2"></i> Painel Administrativo
        </a>
      </li>
      <li><hr class="dropdown-divider"></li>
    <?php endif; ?>

    <li><a class="dropdown-item text-danger" href="logout.php">
      <i class="bi bi-box-arrow-right me-2"></i> Sair
    </a></li>

  </ul>
</div>



    </div>
  </div>
</header>



  
  <!-- BANNER PRINCIPAL -->
<section class="banner">
  <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
    
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1" aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2" aria-label="Slide 3"></button>
    </div>

    <div class="carousel-inner">
      <div class="carousel-item active" data-bs-interval="5000">
        <img src="img/img1.jpg" class="d-block w-100" alt="Imagem 1">
        <div class="carousel-caption d-none d-md-block">
          <h5>Oftalmo</h5>
          <p>Agende já sua consulta com nosso melhor oftalmo.</p>
        </div>
      </div>

      <div class="carousel-item" data-bs-interval="5000">
        <img src="img/img2.jpg" class="d-block w-100" alt="Imagem 2">
        <div class="carousel-caption d-none d-md-block">
          <h5>Ultrassonografias</h5>
          <p>Agende já sua ultrassom pelos melhores preços.</p>
        </div>
      </div>

      <div class="carousel-item" data-bs-interval="5000">
        <img src="img/img3.jpg" class="d-block w-100" alt="Imagem 3">
        <div class="carousel-caption d-none d-md-block">
          <h5>Análises Clínicas</h5>
          <p>Com seu pedido médico, passe na recepção para saber os preços dos exames de análise.</p>
        </div>
      </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Anterior</span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Próximo</span>
    </button>
  </div>
</section>


 <!-- FORMULÁRIO DE AGENDAMENTO -->
<section class="agendamento">
  <div class="container d-flex justify-content-center align-items-center min-vh-100">
  <div class="card shadow-lg p-4 rounded-4" style="max-width: 700px; width: 100%;">
    <h2 class="text-center text-success fw-bold mb-4">
  Bem-vindo(a), <?php echo htmlspecialchars($nomeUsuario); ?>!
</h2>


    <form id="formAgendamento" action="processa_agendamento.php" method="POST">
      <!-- 🧍 Etapa 1 - Dados do paciente -->
   <div class="mb-3">
  <label class="form-label">Nome Completo:</label>
  <input type="text" name="nome" class="form-control" 
    placeholder="Digite seu nome completo" required
    value="<?php echo isset($_SESSION['nome']) ? htmlspecialchars($_SESSION['nome']) : ''; ?>">
</div>

<div class="mb-3">
  <label class="form-label">CPF:</label>
  <input type="text" name="cpf" class="form-control" 
    placeholder="000.000.000-00" required
    value="<?php echo isset($_SESSION['cpf']) ? htmlspecialchars($_SESSION['cpf']) : ''; ?>">
</div>

<div class="mb-3">
  <label class="form-label">Telefone:</label>
  <input type="text" name="telefone" class="form-control" 
    placeholder="(00) 00000-0000" required
    value="<?php echo isset($_SESSION['telefone']) ? htmlspecialchars($_SESSION['telefoneCelular']) : ''; ?>">
</div>

<div class="mb-3">
  <label class="form-label">E-mail:</label>
  <input type="email" name="email" class="form-control" 
    placeholder="exemplo@dominio.com" required
    value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>">
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
</section>


  <!-- MÉDICOS -->
  <section id="medicos">
    <h2 class="text-center">Médicos</h2>
    <div class="medicos-container">
      <div class="medico-card">
        <img src="img/dermatologista.jpg" alt="Médico 1">
        <h3>Dra. Renata Martins</h3>
        <p>Dermatologista</p>
      </div>

      <div class="medico-card">
        <img src="img/clinicogeral.jpg" alt="Médico 2">
        <h3>Dra. Luana Almeida</h3>
        <p>Clínico Geral</p>
      </div>

      <div class="medico-card">
        <img src="img/ginecologista.jpg" alt="Médico 3">
        <h3>Dra. Patrícia Souza</h3>
        <p>Ginecologista</p>
      </div>
    </div>
  </section>

  <!-- FEEDBACK -->
  <section class="feedback-carousel">
    <h2>Feedback</h2>
    <div id="carouselFeedbackText" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <div class="carousel-item active">
          <div class="feedback-banner">
            <p>"Atendimento excelente, me senti muito acolhida!"</p>
            <span>- Luiza Santos</span>
          </div>
        </div>

        <div class="carousel-item">
          <div class="feedback-banner">
            <p>"A médica foi super atenciosa, recomendo demais!"</p>
            <span>- Carla Oliveira</span>
          </div>
        </div>

        <div class="carousel-item">
          <div class="feedback-banner">
            <p>"Ambiente agradável e equipe profissional."</p>
            <span>- João Vitor</span>
          </div>
        </div>
        

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"A médica foi super atenciosa, recomendo demais!"</p>
    <span>- Carla Oliveira</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"Excelente atendimento, saí da consulta muito satisfeita."</p>
    <span>- Juliana Ramos</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"Profissionais incríveis, atendimento rápido e eficiente."</p>
    <span>- Fernando Alvez</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"O doutor foi muito cuidadoso e explicou tudo com clareza."</p>
    <span>- Lucas Andrade</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"Clínica organizada e acolhedora. Me senti em casa!"</p>
    <span>- Amanda Costa</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"Adorei a consulta, atendimento humanizado e de qualidade."</p>
    <span>- Bruno Ferreira</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"Fui muito bem atendida, recomendo de olhos fechados."</p>
    <span>- Rafaela Martins</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"O atendimento foi rápido, eficaz e com muito carinho."</p>
    <span>- Camila Rocha</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"Excelente experiência! Profissionais que realmente se importam."</p>
    <span>- Vladmir Seara</span>
  </div>
</div>

<div class="carousel-item">
  <div class="feedback-banner">
    <p>"A consulta foi ótima! Me senti escutada e bem cuidada."</p>
    <span>- Ana Beatriz</span>
  </div>
</div>


      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#carouselFeedbackText" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselFeedbackText" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
      </button>
    </div>
  </section>

  <!-- RODAPÉ -->
  <footer class="footer">
    <p>© 2025 Raízes da Saúde. Todos os direitos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/agendar.js"></script>
  

</body>
</html>
