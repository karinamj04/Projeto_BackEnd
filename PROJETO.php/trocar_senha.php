<?php
session_start();
if (!isset($_SESSION['email_troca'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Trocar Senha - Raízes da Saúde</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      background: #000;
      overflow-x: hidden;
    }

    .imagem-fundo {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      pointer-events: none;
    }

    .imagem-fundo img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(0.5);
    }

    .box-geral {
      background-color: rgba(255, 255, 255, 0.15);
      border-radius: 1rem;
      backdrop-filter: blur(10px);
      box-shadow: 0 4px 25px rgba(0, 0, 0, 0.5);
      padding: 2.5rem 3rem;
      max-width: 500px; /* aumentei de 420px para 600px */
      width: 100%;
      text-align: center;
    }

    h1 {
      font-family: 'Georgia', serif;
      font-size: 2.2rem;
      color: #fff;
      text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.7);
      border-bottom: 3px solid #28a745;
      display: inline-block;
      margin-bottom: 2rem;
      padding-bottom: 0.3rem;
    }

    .form-label {
      font-weight: 500;
      text-align: left;
      display: block;
      margin-bottom: 0.4rem;
    }

    .input-group {
      position: relative;
    }

    .form-control {
     background-color: #fff;
     border: 1px solid #d1d9e6;
     border-radius: 10px !important;
     padding: 1rem 3rem 1rem 1rem; /* Aumentei o padding vertical para 1rem */
     transition: all 0.3s ease;
     width: 100%;
     height: 2.5rem; /* Altura maior para o campo */
     box-sizing: border-box; /* Para garantir que padding não aumente além da altura */
}


    .form-control:focus {
      background-color: #eef4ff;
      border-color: #28a745;
      box-shadow: 0 0 6px rgba(40, 167, 69, 0.5);
      outline: none;
    }

    .btn-olho {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      background: transparent;
      border: none;
      cursor: pointer;
      color: #777;
      font-size: 1.3rem;
      z-index: 5;
      transition: color 0.3s ease, transform 0.1s ease;
      padding: 0;
      user-select: none;
    }

    .input-group:focus-within .btn-olho {
      color: #28a745;
    }

    .btn-olho:hover {
      color: #28a745;
    }

    .btn-salvar {
      background-color: #28a745;
      border: none;
      color: #fff;
      padding: 0.75rem;
      width: 100%;
      border-radius: 0.35rem;
      font-size: 1.1rem;
      transition: background-color 0.3s ease, transform 0.1s ease;
      margin-top: 1.2rem;
    }

    .btn-salvar:hover {
      background-color: #218838;
    }

    footer {
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      font-size: 0.875rem;
      color: #fff;
    }
  </style>
</head>
<body>
  <div class="imagem-fundo">
    <img src="img/fundo.jpg" alt="Fundo decorativo">
  </div>

  <div class="box-geral">
    <h1>Trocar Senha</h1>
    <form action="processa_troca_senha.php" method="POST">
      <div class="mb-3">
        <label for="novaSenha" class="form-label">Nova Senha</label>
        <div class="input-group">
          <input type="password" class="form-control" id="novaSenha" name="novaSenha" placeholder="Digite a nova senha" required minlength="6">
          <button type="button" class="btn-olho" tabindex="-1" onclick="toggleSenha('novaSenha', this)">
            <i class="bi bi-eye-fill"></i>
          </button>
        </div>
      </div>

      <div class="mb-3">
        <label for="confirmarSenha" class="form-label">Confirmar Nova Senha</label>
        <div class="input-group">
          <input type="password" class="form-control" id="confirmarSenha" name="confirmarSenha" placeholder="Confirme a nova senha" required minlength="6">
          <button type="button" class="btn-olho" tabindex="-1" onclick="toggleSenha('confirmarSenha', this)">
            <i class="bi bi-eye-fill"></i>
          </button>
        </div>
      </div>

      <button type="submit" class="btn-salvar">Salvar Nova Senha</button>
    </form>
  </div>

  <footer>Raiz Saúde. Todos os direitos reservados.</footer>

  <script>
    // Exibir/ocultar senha
    function toggleSenha(id, btn) {
      const input = document.getElementById(id);
      const icone = btn.querySelector('i');
      if (input.type === 'password') {
        input.type = 'text';
        icone.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
      } else {
        input.type = 'password';
        icone.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
      }
    }

    // Validação simples
    document.querySelector('form').addEventListener('submit', function(e) {
      const s1 = document.getElementById('novaSenha').value;
      const s2 = document.getElementById('confirmarSenha').value;
      if (s1 !== s2) {
        alert("As senhas não coincidem!");
        e.preventDefault();
      }
    });
  </script>
</body>
</html>
