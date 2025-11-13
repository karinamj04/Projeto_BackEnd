<!DOCTYPE html>
<html lang="pt-br">
<head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Raízes da Saúde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="css/login.css"/>
</head>
<body>
  <header class="text-center my-4">
    <h1>Raízes Da Saúde</h1>
  </header>

  <main class="container">
    <h2>Login</h2>
    

    <form action="valida.php" method="POST" autocomplete="on">
      <div class="mb-3">
        <label for="idEmail" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="idEmail" name="email" required placeholder="exemplo@gmail.com"/>
      </div>

      
     <div class="mb-3 position-relative">
       <label for="idSenha" class="form-label">Senha</label>
       <input type="password" class="form-control pr-5" id="idSenha" name="senha" required placeholder="Digite sua senha"/>
       <i class="bi bi-eye-fill" id="btn-exibirSenha"></i>
      </div>

      <!-- Links alinhados à esquerda acima do botão -->
     <div class="links-acoes mb-3">
  <a href="confirmaridentidade.php" class="link-esqueceu-senha">Esqueceu a senha ?</a><br/>
  <span class="nao-tem-conta">Não tem conta? </span><a href="cadastro.php" class="link-cadastro">Cadastre-se</a>
</div>


<div class="botoes-login">
  <!-- botão que envia o formulário -->
  <button type="submit" name="login" class="btn btn-verde btn-enviar">
    Entrar
  </button>

  <!-- botão que limpa os campos -->
  <button type="reset" class="btn btn-limpar">
    Limpar
  </button>
</div>

    </form>
  </main>

  <footer class="text-center mt-5">
    <div class="footer-container">
      <p>© 2025 Raízes da Saúde. Todos os direitos reservados.</p>
    </div>
  </footer>

  <div class="imagem-fundo">
    <img src="img/fundo.jpg" alt="Imagem de fundo" class="img-fluid w-100"/>
  </div>

<script src="js/login.js"></script>

</body>
</html>