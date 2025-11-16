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
    <title>Usuário - Visualizar - Raízes da Saúde</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <div class='container mt-5'>
      <div class='row'>
        <div class='col-md-12'>
          <div class='card'>
            <div class='card-header'>
              <h4>Visualizar Dados do Paciente
                <a href='crud.php' class='btn btn-danger float-end'>VOLTAR</a>
              </h4>
            </div>
            <div class='card-body'>
              <?php
              if(isset($_GET['cpf'])){
                $usuario_cpf = mysqli_real_escape_string($conn, $_GET['cpf']);
                $sql = "SELECT * FROM usuarios WHERE cpf='$usuario_cpf'";
                $query = mysqli_query($conn, $sql);

                if(mysqli_num_rows($query) > 0){
                  $usuario = mysqli_fetch_array($query);
              ?>
                <div class="mb-3">
                  <label>CPF</label>
                  <p class="form-control"><?= $usuario['cpf']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Nome</label>
                  <p class="form-control"><?= $usuario['nome']; ?></p>
                </div> 

                <div class="mb-3">
                  <label>Sobrenome</label>
                  <p class="form-control"><?= $usuario['sobrenome']; ?></p>
                </div> 

                <div class="mb-3">
                  <label>Data de Nascimento</label>
                  <p class="form-control"><?= date('d/m/Y', strtotime($usuario['DataNascimento'])); ?></p>
                </div> 

                <div class="mb-3">
                  <label>Nome Materno</label>
                  <p class="form-control"><?= $usuario['nomeMaterno']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Sexo</label>
                  <p class="form-control"><?= $usuario['sexo']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Endereço</label>
                  <p class="form-control"><?= $usuario['endereco']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Bairro</label>
                  <p class="form-control"><?= $usuario['bairro']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Estado</label>
                  <p class="form-control"><?= $usuario['estado']; ?></p>
                </div>

                <div class="mb-3">
                  <label>CEP</label>
                  <p class="form-control"><?= $usuario['cep']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Cidade</label>
                  <p class="form-control"><?= $usuario['cidade']; ?></p>
                </div>

                <div class="mb-3">
                  <label>Email</label>
                  <p class="form-control"><?= $usuario['email']; ?></p>
                </div> 

                <div class="mb-3">
                  <label>Celular</label>
                  <p class="form-control"><?= $usuario['telefoneCelular']; ?></p>
                </div> 
              <?php
                } else {
                  echo "<h5>Nenhum CPF encontrado</h5>";
                }
              }
              ?>    
            </div>
          </div>
        </div>
      </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
