<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirme sua Identidade - Raízes da Saúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/confirmarIdentidade.css">
</head>

<body>
    <header class="text-center my-4">
        <h1>Confirme sua Identidade</h1>
    </header>

    <main class="container">
        <h2 id="pergunta">Para alterar a senha, precisamos confirmar que essa conta é sua.</h2>

        <form id="formCpf">

            <div class="mb-3">
                <label for="cpf" class="form-label text-light">Qual é o seu CPF?</label>
                <input type="text" id="cpf" name="cpf" class="form-control" placeholder="Digite seu CPF" maxlength="14"
                    required>
            </div>
            <button type="submit" class="btn-verde">Enviar</button>
        </form>

        <p id="mensagem" class="mt-3 text-warning"></p>
    </main>

    <footer class="text-center mt-5">
        <div class="footer-container">
            <p>© 2025 Raízes da Saúde. Todos os direitos reservados.</p>
        </div>
    </footer>

    <div class="imagem-fundo">
        <img src="img/fundo.jpg" alt="Imagem de fundo" class="img-fluid w-100" />
    </div>

    <script src="js/confirmarIdentidade.js"></script>
</body>

</html>