<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$adminNome = $_SESSION['nome'] ?? 'Administrador';
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Criar Acesso - Raízes da Saúde</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

   <!-- Sidebar (mantida exatamente como estava) -->
  <div class="sidebar p-3">
    <h3 class="mb-4 fw-bold">Raiz Saúde    </h3>
     <nav class="nav flex-column">

      <a href="admin.php">Painel de Consultas</a>
      <a href="admin_cadastro.php">Cadastrar</a>
      <a href="criar_acesso.php" class="nav-link">
      <i class="bi bi-key me-2"></i> Criar Acesso
    </a>

      <a href="crud.php">Pacientes</a>
      <a href="consultas.php">Consultas</a>
      <a href="log.php">Relatórios</a>
      <a href="configuracoes.php" >Configurações</a>
      <a href="sistema.php" class="link-secondary link-offset-2 link-underline-opacity-25 link-opacity-100-hover">
      <i class="bi bi-person"></i> Sistema
    </a>
      <a href="logout.php" class="nav-link text-danger">
      <i class="bi bi-box-arrow-right me-2"></i> Sair
    </a>

    </nav>
  </div>

  <!-- Main -->
  <div class="flex-grow-1 d-flex flex-column">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-4">
      <div class="ms-auto d-flex align-items-center">
        <span class="me-2 fw-semibold text-success">
          Bem-vindo(a), <?php echo htmlspecialchars($adminNome); ?>!
        </span>
        <img src="uploads/admin.jpg" alt="Foto do administrador" class="rounded-circle profile-pic" id="adminFoto">
      </div>
    </nav>

    <div class="container mt-5">
      <div class="row justify-content-center">
        <div class="col-md-6">
          <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
              <h4 class="mb-0">Criar Acesso de Administrador</h4>
            </div>
            <div class="card-body">

              <?php if (isset($_SESSION['mensagem'])): ?>
                <div class="alert alert-info">
                  <?php 
                    echo $_SESSION['mensagem']; 
                    unset($_SESSION['mensagem']);
                  ?>
                </div>
              <?php endif; ?>

<form action="acoes_admin.php" method="POST" id="form-admin">

  <div class="mb-3">
    <label for="cpf" class="form-label">CPF</label>
    <input 
      type="text" 
      id="cpf" 
      name="cpf" 
      class="form-control" 
      placeholder="(000.000.000-00)" 
      maxlength="14"
      required
    >
  </div>

  <div class="mb-3">
    <label for="nome" class="form-label">Nome completo</label>
    <input 
      type="text" 
      id="nome" 
      name="nome" 
      class="form-control" 
      placeholder="Como consta no documento"
      required
    >
  </div>

  <div class="mb-3">
    <label for="email" class="form-label">E-mail</label>
    <input 
      type="email" 
      id="email" 
      name="email" 
      class="form-control" 
      placeholder="nome.sobrenome@raizsaude.br"
      pattern="^[a-zA-Z0-9._%+-]+@[rR][aA][iI][zZ][sS][aA][uU][dD][eE]\.[bB][rR]$"
      title="O e-mail deve seguir o formato nome.sobrenome@raizsaude.br"
      required
    >
  </div>
  <div class="mb-3">
  <label>Nome da Mãe</label>
  <input placeholder="Como consta no documento" type="text" name="nomeMaterno" class="form-control" required>
</div>

<div class="mb-3">
  <label>CEP</label>
  <input placeholder="00000-000" type="text" id="cep" name="cep" class="form-control" required>
</div>

<div class="mb-3">
  <label>Data de Nascimento</label>
  <input type="date" name="DataNascimento" class="form-control" required>
</div>

  <div class="text-end">
    <button type="submit" name="criar_admin" class="btn btn-success">Criar Acesso</button>
  </div>

</form>
        

            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <script>
// Máscara simples para CEP
document.getElementById('cep').addEventListener('input', function(e) {
    let valor = e.target.value.replace(/\D/g, ''); // remove tudo que não é número
    if (valor.length > 5) {
        valor = valor.substring(0,5) + '-' + valor.substring(5,8);
    }
    e.target.value = valor;
});
</script>
<script>
  // Máscara de CPF automática
document.getElementById('cpf').addEventListener('input', function (e) {
  let valor = e.target.value.replace(/\D/g, ''); // mantém só números para aplicar a máscara
  if (valor.length > 11) valor = valor.slice(0, 11); // limita a 11 dígitos numéricos

  // Aplica a formatação: 000.000.000-00
  if (valor.length > 9) {
    valor = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
  } else if (valor.length > 6) {
    valor = valor.replace(/(\d{3})(\d{3})(\d{1,3})/, "$1.$2.$3");
  } else if (valor.length > 3) {
    valor = valor.replace(/(\d{3})(\d{1,3})/, "$1.$2");
  }

  e.target.value = valor;
});


  // Geração automática do e-mail com base no nome
  document.getElementById('nome').addEventListener('input', function () {
    const nomeInput = this.value.trim().toLowerCase();

    // Separa o nome e o sobrenome
    const partes = nomeInput.split(' ').filter(Boolean);
    if (partes.length >= 2) {
      const nome = partes[0].normalize("NFD").replace(/[\u0300-\u036f]/g, "");
      const sobrenome = partes[partes.length - 1].normalize("NFD").replace(/[\u0300-\u036f]/g, "");
      document.getElementById('email').value = `${nome}.${sobrenome}@raizsaude.br`;
    }
    
  });
</script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
<script src="js/admin.js"></script>

</body>
</html>
