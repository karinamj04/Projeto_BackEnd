<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contato- Raízes da Saúde</title>
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link rel="stylesheet" href="css/contato.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">


</head>
<body>

  <!-- NAVBAR -->
<!-- NAVBAR UNIVERSAL -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="home.php">Raízes da Saúde</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse navigation" id="navbarNav">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        
        <!-- Home -->
        <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>

        <!-- Especialidades -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Especialidades
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="quemsomos.php">Ginecologia e Obstetrícia</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Pediatria</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Cardiologista</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Ortopedista</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Dermatologista</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Psiquiatria</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="cadastro.php">Agende sua consulta</a></li>
          </ul>
        </li>

        <!-- Exames -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            Exames
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="quemsomos.php">Hemograma completo</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Ultrassom</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Tomografia</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Eletrocardiograma</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">Raio-X</a></li>
            <li><a class="dropdown-item" href="quemsomos.php">MAPA</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="cadastro.php">Agende sua consulta</a></li>
          </ul>
        </li>
 
        <!-- Sobre nós -->
        <li class="nav-item">
          <a class="nav-link" href="sobrenos.php">Sobre nós</a>
        </li>

      </ul>

      <!-- Botão Cadastre-se -->
      <button id="cadastro" class="ms-lg-3" onclick="window.location.href='cadastro.php'">Cadastre-se</button>
    </div>
  </div>
</nav>



  <!--------------------------------NOSSO CONTATO------------------------------>

<div class="section">
  <div class="container">
    <div class="content-section">
      <div class="tittle">
        <h1>Contato</h1>
      </div>
      <div class="content">
        <h3> Encontre nossos contatos e meios de comunicação abaixo   </h3>
        <p> <i class="bi bi-geo"></i>   Av. Paris, 84 - Bonsucesso, Rio de Janeiro - RJ, 21041-020 </p>
         <p> <i class="bi bi-telephone"></i>   (21) 3882-9797 </p>
        <p>Cuide de você. Entre em contato e descubra como podemos ajudar!</p>

        <div class="button">
          <a href="quemsomos.php" >Saiba mais</a>
        </div>
      </div>
      <div class="social">
        <a  href="https://www.facebook.com/share/16V3CuPvPG/" target="_blank" ><i class="bi bi-facebook"></i></a>
        <a href="https://chat.whatsapp.com/Dn35pJhzv1z6u2CvgXcay7 "target="_blank" ><i class="bi bi-whatsapp"></i></a>
        <a href="https://www.instagram.com/clinicaraizsaude/" target="_blank" ><i class="bi bi-instagram"></i></a>
      </div>
    </div>
    <div class="image-section">
      <img src="img/imagem.jpg" alt="">
    </div>
  </div>
</div>














 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
  <script>
    // Quando a página carregar...
    document.addEventListener("DOMContentLoaded", function () {
      // Seleciona o botão pelo ID
      const botao = document.getElementById("cadastro");

      // Adiciona o evento de clique
      botao.addEventListener("click", function () {
        // Redireciona para a outra página
        window.location.href = "cadastro.php";
      });
    });
  </script>
</body>
</html>
