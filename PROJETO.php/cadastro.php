<?php
include ('conexao.php');
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro - Raízes da Saúde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
  <link rel="stylesheet" href="css/cadastro.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>

<body>
  <header class="text-center my-4">
    <h1>
      Raízes Da Saúde
    </h1>
  </header>

  <main class="container">
    <h5>Estamos quase lá</h5>
    <p>Agora é só preencher o formulário abaixo para receber o seu acesso. Simples assim!</p>
    <!--CADASTRO-->
    <form method="post" action="inseri.php" autocomplete="on">

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="idNome" class="form-label">Nome</label>
          <input type="text" class="form-control" name="nome" id="idNome" required placeholder="Digite seu primeiro nome">
        </div>
        <div class="col-md-6 mb-3">
          <label for="idSobrenome" class="form-label">Sobrenome</label>
          <input type="text" class="form-control" name="sobrenome" id="idSobrenome" required placeholder="Digite seu sobrenome">
        </div>
        <div class="col-md-6 mb-4">
          <label for="idDataNascimento" class="form-label">Data de Nascimento</label>
          <input type="date" class="form-control" name="dataNascimento" id="idDataNascimento" required>
        </div>

        <div class="col-md-6 mb-4">
          <label for="idnomeMaterno" class="form-label">Nome Materno</label>
          <input type="text" class="form-control" id="idnomeMaterno" name="nomeMaterno" required placeholder="Digite o nome da sua mãe">
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="idCpf" class="form-label">CPF</label>
          <input type="text" class="form-control" name="cpf" id="idCpf" placeholder="Ex: 123.456.789-00" required>
        </div>
        <div class="col-md-6 mb-3">
          <label for="sexo" class="form-label">Sexo</label>
          <select class="form-select" id="sexo" name="sexo" required>
            <option disabled selected value="">Selecione</option>
            <option value="M">Masculino</option>
            <option value="F">Feminino</option>
            <option value="O">Outros</option>
            <option value="P">Prefiro não responder</option>
          </select>
        </div>
      </div>

      <!-- Colocando o CEP antes do Endereço -->
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="idCep" class="form-label">CEP</label>
          <input type="text" class="form-control" name="cep" id="cep" placeholder="Ex: 12345-678" required>
        </div>
        <div class="col-md-9 mb-3">
          <label for="idEndereço" class="form-label">Endereço</label>
          <input type="text" class="form-control" name="endereco" id="rua" placeholder="Ex: Rua das Flores, 123" required>
        </div>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="idBairro" class="form-label">Bairro</label>
          <input type="text" class="form-control" name="bairro" id="bairro" placeholder="Ex: Centro" required>
        </div>
        <div class="col-md-3 mb-3">
          <label for="idEstado" class="form-label">Estado</label>
          <input type="text" class="form-control" name="estado" id="uf" placeholder="Ex: RJ" required>
        </div>
        <div class="col-md-3 mb-3">
          <label for="idCidade" class="form-label">Cidade</label>
          <input type="text" class="form-control" id="cidade" name="cidade" placeholder="Ex: Rio de Janeiro" required>
        </div>
      </div>

      <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Ex: seuemail@exemplo.com" required>
      </div>

      <div class="row">
        <div class="col-md-6 mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha"  name="senha" placeholder="Crie uma senha segura" required>
          <i class="bi bi-eye-fill" id="btn-exibirSenha"></i>
        </div>
        <div class="col-md-6 mb-3">
          <label for="confirmaSenha" class="form-label">Confirme a Senha</label>
          <input type="password" class="form-control" id="confirmaSenha" name="confirmarSenha" placeholder="Repita a senha" required>
          <i class="bi bi-eye-fill" id="btn-aparecerSenha"></i>
        </div>
      </div>

      <div class="mb-3">
        <label for="telefone" class="form-label">Telefone Celular</label>
        <input type="tel" class="form-control" id="telefone" name="telefoneCelular" placeholder="Ex: (21) 99999-5555" required>
      </div>

      <div id="mensagensErro" class="alert alert-danger d-none" role="alert"></div>
      <button type="submit" class="btn btn-verde">Enviar</button>
    </form>
    <!--FIM DO CADASTRO-->
  </main>
  <!--RODAPÉ-->
  <footer class="text-center mt-5">
    <div class="footer-container">
      <p>© 2025 Raízes da Saúde. Todos os direitos reservados.</p>
      <p>raizesdasaude@gmail.com</p>
    </div>
  </footer>
  <!--IMAGEM-->
  <div class="imagem-fundo">
    <img src="img/fundo.jpg" alt="Imagem de fundo" class="img-fluid w-100">
  </div>

  <!--JAVA SCRIPT E JQUERY-->
  <script src="js/cadastro.js"></script>
</body>

</html>