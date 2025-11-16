<?php
session_start();
include('conexao.php'); // conexão padrão com $conn

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Pega o nome e e-mail direto da sessão (sem consulta)
$adminNome = $_SESSION['nome'] ?? 'Administrador';
$adminEmail = $_SESSION['email'] ?? 'sem_email@dominio.com';
?>

<!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usuário - Editar - Raízes da Saúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class='container mt-5'>
      <div class='row'>
        <div class= 'col-md-12'>
          <div class='card'>
            <div class='card-header'>
              <h4>Editar Usuario
                <a href='crud.php' class='btn btn-danger float-end'>VOLTAR</a>
              </h4>
            </div>
            <div class='card-body'>
                <?php
                if(isset($_GET['cpf'])){
                    $usuario_cpf = mysqli_real_escape_string($conn, $_GET['cpf']);
                    $sql = "SELECT * FROM usuarios WHERE cpf='$usuario_cpf'";
                    $query=mysqli_query($conn, $sql);
        
                    if(mysqli_num_rows($query) > 0){
                        $usuario = mysqli_fetch_array($query);

                ?>
              <form action="acoes.php" method="POST">
                <input type="hidden" name="usuario_cpf" value="<?=$usuario['cpf'];?>">
                <div class="mb-3">
                  <label>CPF</label>
                  <input type="text" name="cpf" value="<?=$usuario['cpf']?>" class="form-control" maxlength="11" inputmode="numeric" pattern="\d{11}" required>
                </div> 

                <div class="mb-3">
                  <label>Nome</label>
                  <input type="text" name="nome" value="<?=$usuario['nome']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Sobrenome</label>
                  <input type="text" name="sobrenome" value="<?=$usuario['sobrenome']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Nome Materno</label>
                  <input type="text" name="nomeMaterno" value="<?=$usuario['nomeMaterno']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Sexo</label>
                  <input type="text" name="sexo" value="<?=$usuario['sexo']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Endereço</label>
                  <input type="text" name="endereco" id="logradouro" value="<?=$usuario['endereco']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Bairro</label>
                  <input type="text" name="bairro" id="bairro" value="<?=$usuario['bairro']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>estado</label>
                  <input type="text" name="estado" id="uf" value="<?=$usuario['estado']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>CEP</label>
                  <input type="text" name="cep" id="cep" value="<?=$usuario['cep']?>" class="form-control">
                </div>
                <div class="mb-3">
                  <label>Cidade</label>
                  <input type="text" name="cidade" id="cidade" value="<?=$usuario['cidade']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Email</label>
                  <input type="text" name="email" value="<?=$usuario['email']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Data de Nascimento</label>
                  <input type="date" name="DataNascimento" value="<?=$usuario['DataNascimento']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Telefone Celular</label>
                  <input type="text" name="telefoneCelular"value="<?=$usuario['telefoneCelular']?>" class="form-control">
                </div>

                <div class="mb-3">
                  <label>Senha</label>
                  <input type="password" name="senha" class="form-control">
                </div>

                <div class="mb-3">
                  <button type="submit" name="update_usuario" class="btn btn-primary">Salvar</button>
                </div>
              </form>
              <?php
               }else{
                echo "<h5>Usuário não encontrado</h5>";
               }
              }
              ?>
            </div>
        </div>
        </div>
      </div>

    </div>
    <script src="js/admin_cadastro.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  </body>
</html>