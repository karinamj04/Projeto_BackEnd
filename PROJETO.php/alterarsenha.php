<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Alterar Senha - Raízes da Saúde</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

  <link rel="stylesheet" href="css/alterarsenha.css">

  <style>
    /* === Olhinho integrado ao campo === */
    .btn-olho {
      background-color: #fff !important; /* fundo branco igual ao input */
      border: 1px solid #ced4da !important; /* mesma borda do campo */
      border-left: none !important;
      color: #aaa;
      display: flex;
      align-items: center;
      justify-content: center;
      width: 45px;
      transition: color 0.3s ease, background-color 0.3s ease;
      border-radius: 0.5rem;
    }

    .btn-olho:hover {
      color: #28a745 !important;
      background-color: #f8f9fa !important;
    }

    .btn-olho:focus {
      box-shadow: none !important;
    }

    /* remove sobreposição de bordas no input */
    .input-group .form-control {
      border-right: none !important;
    }

    /* mantém foco limpo */
    .input-group:focus-within .form-control {
      box-shadow: none !important;
    }
  </style>
</head>

<body>
  <header class="text-center my-4">
    <h1>Alterar Senha</h1>
  </header>

  <main class="container text-center">
    <h2 id="pergunta" class="mb-4">Digite seu CPF e crie uma nova senha</h2>

    <!-- Formulário principal -->
    <form id="form-alterar-senha">
      <div class="mb-3">
        <label for="cpf" class="form-label text-light">CPF</label>
        <input type="text" id="cpf" name="cpf" class="form-control" placeholder="Digite seu CPF" required maxlength="14">
      </div>

      <!-- Nova Senha -->
      <div class="mb-3">
        <label for="novaSenha" class="form-label text-light">Nova Senha</label>
        <div class="input-group">
          <input type="password" id="novaSenha" name="novaSenha" class="form-control" placeholder="Digite a nova senha" required>
          <button type="button" class="btn-olho" id="toggleNovaSenha">
            <i class="bi bi-eye-fill"></i>
          </button>
        </div>
      </div>

      <!-- Confirmar Senha -->
      <div class="mb-3">
        <label for="confirmarSenha" class="form-label text-light">Confirmar Nova Senha</label>
        <div class="input-group">
          <input type="password" id="confirmarSenha" name="confirmarSenha" class="form-control" placeholder="Confirme a nova senha" required>
          <button type="button" class="btn-olho" id="toggleConfirmarSenha">
            <i class="bi bi-eye-fill"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-verde">Salvar Nova Senha</button>
    </form>

    <p id="feedback" class="mt-3 text-warning"></p>
  </main>

  <footer class="text-center mt-5">
    <div class="footer-container">
      <p>© 2025 Raízes da Saúde. Todos os direitos reservados.</p>
    </div>
  </footer>

  <div class="imagem-fundo">
    <img src="img/fundo.jpg" alt="Imagem de fundo" class="img-fluid w-100" />
  </div>

  <!-- mantém sua lógica existente -->
  <script src="js/alterarsenha.js"></script>

  <!-- adiciona a lógica do olho -->
  <script>
    function togglePassword(inputId, buttonId) {
      const input = document.getElementById(inputId);
      const icon = document.querySelector(`#${buttonId} i`);
      if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bi-eye-fill", "bi-eye-slash-fill");
      } else {
        input.type = "password";
        icon.classList.replace("bi-eye-slash-fill", "bi-eye-fill");
      }
    }

    document.getElementById("toggleNovaSenha").addEventListener("click", () => {
      togglePassword("novaSenha", "toggleNovaSenha");
    });

    document.getElementById("toggleConfirmarSenha").addEventListener("click", () => {
      togglePassword("confirmarSenha", "toggleConfirmarSenha");
    });
  </script>
</body>

</html>
