<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/home.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <script type="text/javascript" src="js/darkmode.js" defer></script>
    <script type="text/javascript" src="js/controleFonte.js" defer></script>
    <title>HOME - Raízes da Saúde</title>
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


 <div id="carouselExampleIndicators" class="carousel slide">
  <div class="carousel-indicators">
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
    <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
  </div>
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="img/banner1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/banner2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="img/banner3.png" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

    <div class="texto-esquerda">
        <h1>Bem-vindo à Raízes da Saúde</h1>
        <p>Na Raízes da Saúde, cuidamos de cada paciente com carinho, responsabilidade e respeito.
        Nossa missão é oferecer um cuidado humanizado e acessível, promovendo a saúde e o bem-estar de todos.
        Com consultas a partir de R$90,00, nosso atendimento é simples, eficiente e realizado por profissionais qualificados.

        Valorizamos a escuta, o acolhimento e a confiança, garantindo que cada pessoa se sinta segura e bem cuidada desde o primeiro contato
        </p>
       <a href="contato.php" id="btn-Contato" >Nosso Contato</a>
    
    </div>
    




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>


</body>
</html>
