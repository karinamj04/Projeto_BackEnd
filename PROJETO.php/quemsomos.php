<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Quem Somos - Raízes da Saúde</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Ícones Bootstrap -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/quemsomos.css">
  <script type="text/javascript" src="js/darkmode.js" defer></script>
  <script type="text/javascript" src="js/controleFonte.js" defer></script>

</head>
<body>

<header>
      <!------------------------------NOSSA LOGO------------------------->
        <h2 class="logo">Raízes da Saúde</h2>

        <nav class="navigation">

          <ul class="nav nav-tabs">
            <li class="nav-item">
              <a class="nav-link" href="home.php">Home</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Especialidades</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="quemsomos.php">Genicologista e Obstetrícia</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Pediatria</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Cardiologista</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Ortopedista</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Dermatologista</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Psiquiatria</a></li>
                 <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="cadastro.php">Agende sua consulta</a></li>
             
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false">Exames</a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="quemsomos.php">Hemograma completo</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Ultrassom</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Tomografia</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Eletrocardiograma</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Raio-x</a></li>
                <li><a class="dropdown-item" href="quemsomos.php">Mapa</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="cadastro.php">Agende sua consulta</a></li>
              </ul>
            </li> 
          
            <li class="nav-item">
              <a class="nav-link" href="sobrenos.php">Sobre Nós</a>
            </li>
            <button id="ModoEscuro"><i class="bi bi-moon-fill"></i><i class="bi bi-brightness-high-fill"></i></button>
            </nav>

          <a id="login" href="login.php">login</a>

          
    </header>

   <!--Botôes de aumentar e diminuir fonte-->
    <div class="font-buttons">
        <button class="button-alterFont" onclick="adjustFontSize(1)">A+</button>
        <button class="button-alterFont" onclick="adjustFontSize(-1)">A-</button>
    </div>

<!-- CONTEÚDO PRINCIPAL -->
<section class="section py-5">
  <div class="container d-flex flex-lg-row flex-column align-items-center gap-4">
    
    <div class="content-section">
      <div class="title">
        <h1>Quem Somos</h1>
      </div>
      <div class="content">
        <h3>Nosso Atendimento</h3>
        <p>Na nossa clínica, o atendimento é humanizado, acolhedor e eficiente. Valorizamos cada paciente, oferecendo um ambiente seguro e confortável desde a recepção até o pós-consulta.</p>

        <h3>Médicos de Qualidade</h3>
        <p>Contamos com uma equipe de médicos altamente capacitados, experientes e dedicados. Nossos profissionais atuam com ética, empatia e atualizações constantes.</p>

        <h3>Exames na Clínica</h3>
        <p>Realizamos diversos exames com segurança e precisão. O agendamento é feito somente de forma presencial.</p>

        <h3>Como funciona:</h3>
        <p>Traga o pedido médico até a recepção. Você receberá informações sobre valores, preparo e horários disponíveis.</p>

        <div class="button mt-3">
          <a href="contato.php">Saiba mais</a>
        </div>
      </div>
    </div>

    <div class="image-section">
      <img src="img/imagem.jpg" class="img-fluid rounded shadow" alt="Imagem Quem Somos">
    </div>

  </div>
</section>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
