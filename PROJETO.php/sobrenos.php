<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/sobrenos.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript" src="js/darkmode.js" defer></script>
  <script type="text/javascript" src="js/controleFonte.js" defer></script>
  <title>Sobre Nós - Raízes da Saúde </title>
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

  <!-- CONTEÚDO -->
  <div class="sobre-nos">
    <div class="texto">
      <div class="caixa-transparente">
        <h1>Sobre nós</h1>
        <p>Somos um grupo de estudantes apaixonados por tecnologia, unidos para desenvolver o projeto "Raízes da Saúde". Nosso objetivo foi criar uma solução simples, funcional e acessível, que pudesse refletir cuidado, organização e propósito.</p>
        <p>O trabalho foi dividido entre os integrantes para garantir eficiência e colaboração:</p>
        <ul>
      <li><strong>Arthur:</strong> Responsável pela atualização da página principal “Home”, pela documentação do projeto e pela produção dos códigos dos desafios de contraste claro e escuro, além do aumento e diminuição de fonte, garantindo uma estrutura moderna e responsiva.</li><br>

      <li><strong>Lucas e Yago:</strong> Responsáveis pelo desenvolvimento completo das páginas de autenticação em dois fatores, incluindo a implementação da lógica de verificação de usuários e segurança adicional. Também criaram a tela de alteração de senha, garantindo que os usuários possam atualizar suas credenciais de forma segura e intuitiva, contribuindo diretamente para a melhoria da experiência do usuário e a proteção dos dados no sistema.</li><br>

      <li><strong>Maria Julia:</strong> Responsável pelo desenvolvimento do <em>valida.php</em>, incluindo a validação dos dados de login e a lógica da autenticação de dois fatores com condições de nível de acesso. Criou a tela <em>sistema.php</em> para agendamento dos pacientes, além do banco de dados que armazena esses agendamentos. Também desenvolveu a tela <em>admin.php</em>, destinada ao nível de acesso master, onde apenas o administrador tem permissão. Atualizou a página de login e criou a tela modelo do banco de dados, garantindo organização e eficiência na gestão das informações do sistema.</li><br>

      <li><strong>Miguel:</strong> Responsável pela criação da tela de login, garantindo que os usuários possam acessar o sistema de forma segura e intuitiva. Sua implementação estabelece a primeira interface de interação do usuário com o sistema, sendo fundamental para o controle de acesso e experiência inicial de navegação.</li><br>

      <li><strong>Paulo:</strong> Responsável pelo desenvolvimento completo das páginas “Log” e “Sobre Nós”, garantindo que a navegação e a apresentação das informações fossem claras e intuitivas para os usuários. Suas contribuições ajudaram a estruturar melhor a interface do sistema, promovendo uma experiência mais organizada e funcional.</li><br>

      <li><strong>Pedro:</strong> Responsável pelo desenvolvimento do sistema de cadastro de usuários, incluindo a <em>INSERI</em>, a criação do banco de dados que armazena os usuários, integração com APIs e a implementação da tela de erro. Suas contribuições garantiram o correto armazenamento e validação de dados, além de oferecer feedback claro aos usuários em caso de falhas.</li><br>

      <li><strong>Rafael:</strong> Responsável pelo desenvolvimento do CRUD do sistema e pela criação dos códigos dos desafios, incluindo a implementação do recurso de exportar a lista de usuários em PDF. Suas contribuições garantiram a funcionalidade completa das operações e a geração de relatórios de forma prática e eficiente.</li><br>

        </ul>
        <p>Este projeto é resultado do nosso comprometimento, aprendizado e vontade de entregar algo útil e bem-feito. Agradecemos a todos que acompanharam e contribuíram com o desenvolvimento da "Raízes da Saúde".</p>
      </div>
    </div>

    <div class="imagens">
      <img src="img/maju.jpg" alt="Maria Julia">
      <img src="img/paulo.jpg" alt="Paulo">
      <img src="img/pedro.jpg" alt="Pedro">
      <img src="img/miguel.jpg" alt="Miguel">
      <img src="img/rafael.jpg" alt="Rafael">
      <img src= "img/arthur.jpg" alt="Arhtur">
      <img src="img/lucas.jpg" alt="Yucas">
      <img src="img/yago.jpg" alt="Yago">
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

  
  </script>
</body>
</html>
