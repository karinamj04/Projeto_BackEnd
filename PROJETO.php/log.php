<?php
session_start();
include('conexao.php'); // conexão padrão com $conn

// Verifica se o usuário está logado e é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Pega o filtro de busca do usuário (nome ou cpf)
$filtro = isset($_GET['busca']) ? trim($_GET['busca']) : '';

if ($filtro) {
    // Escapa e limpa o filtro
    $filtro_esc = $conn->real_escape_string($filtro);
    // Remove qualquer caractere que não seja número
    $filtro_numerico = preg_replace('/\D/', '', $filtro_esc);

    $sql = "
        SELECT la.*, u.nome
        FROM logs_autenticacao la
        LEFT JOIN usuarios u ON la.cpf = u.cpf
        WHERE 
            u.nome LIKE '%$filtro_esc%' 
            OR REPLACE(REPLACE(REPLACE(la.cpf, '.', ''), '-', ''), '/', '') LIKE '%$filtro_numerico%'
        ORDER BY la.data_hora DESC
    ";
} else {
    $sql = "
        SELECT la.*, u.nome
        FROM logs_autenticacao la
        LEFT JOIN usuarios u ON la.cpf = u.cpf
        ORDER BY la.data_hora DESC
    ";
}

$result = $conn->query($sql);

// Pega o nome e e-mail direto da sessão (sem consulta)
$adminNome = $_SESSION['nome'] ?? 'Administrador';
$adminEmail = $_SESSION['email'] ?? 'sem_email@dominio.com';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Relatórios - Raízes da Saúde </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/logs.css">
  <link rel="stylesheet" href="css/admin.css">
</head>
<body>

     <!-- Sidebar (mantida exatamente como estava) -->
  <div class="sidebar p-3">
    <h3 class="mb-4 fw-bold">Raiz Saúde    </h3>
    <nav class="nav flex-column">
      <a href="admin.php">Painel de Consultas</a>
      <a href="admin_cadastro.php">Cadastrar</a>
      <a href="criar_acesso.php">Criar Acesso</a>
      <a href="crud.php">Pacientes</a>
      <a href="consultas.php">Consultas</a>
      <a href="log.php" class="nav-link">
      <i class="bi bi-file-earmark-text me-2"></i> Relatórios
    </a>

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
        <img src="uploads/admin.png" alt="Foto do administrador" class="rounded-circle profile-pic" id="adminFoto">
      </div>
    </nav>

   <main>
    <h2>Logs de Autenticação</h2>

    <form method="GET" action="log.php" class="mb-3 d-flex align-items-center gap-2" style="max-width: 400px;">
  <input 
      type="text" 
      name="busca" 
      class="form-control" 
      placeholder="Buscar por nome ou CPF" 
      value="<?= htmlspecialchars($filtro ?? '') ?>">
  
  <button type="submit" class="btn btn-success">Buscar</button>
  
  <!-- Botão de limpar filtro -->
  <a href="log.php" class="btn btn-secondary">Limpar</a>
</form>

    <?php if ($result && $result->num_rows > 0): ?>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Data e Hora</th>
                <th>Nome do Usuário</th>
                <th>CPF</th>
                <th>2º Fator</th>
                <th>IP</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= date('d/m/Y H:i:s', strtotime($row['data_hora'])) ?></td>
                <td><?= htmlspecialchars($row['nome'] ?? 'N/D') ?></td>
                <td><?= htmlspecialchars($row['cpf']) ?></td>
                <td><?= htmlspecialchars($row['segundo_fator'] ?? 'N/D') ?></td>
                <td><?= htmlspecialchars($row['email'] ?? 'N/D') ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <?php else: ?>
    <p class="mt-3" style="text-align:center;">Nenhum log registrado ainda.</p>
    <?php endif; ?>
  </main>

 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">
  <script src="js/admin.js"></script>

</body>
</html>
