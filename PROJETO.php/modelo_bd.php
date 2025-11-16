<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/modelo_bd.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Modelo Banco de Dados - Raízes da Saúde </title>
<style>
  body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-image: url('img/fundo.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: justify;  
  } 
  
</style>
  
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
                <li><a class="dropdown-item" href="login.php">Agende sua consulta</a></li>
             
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
                <li><a class="dropdown-item" href="login.php">Agende sua consulta</a></li>
                </ul>
              </li>
              
            
              <li class="nav-item">
                <a class="nav-link" href="quemsomos.php">Quem somos</a>
              </li>
  
              </nav>
  
            <button id="cadastro">Login</button>
            
      </header>


<main class="der-container">
    <h2>Modelo do Banco de Dados</h2>
    <div class="der-image-wrapper">
        <img src="img/bd.png" alt="DER do Banco de Dados" class="der-image">
    </div>
</main>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    // Quando a página carregar...
    document.addEventListener("DOMContentLoaded", function () {
      // Seleciona o botão pelo ID
      const botao = document.getElementById("cadastro");

      // Adiciona o evento de clique
      botao.addEventListener("click", function () {
        // Redireciona para a outra página
        window.location.href = "login.php";
      });
    });
  </script>
</body>
</html>