<?php
session_start();
include('conexao.php');

// --- Verifica se o usuário está logado e é admin ---
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// --- Dados do admin logado ---
$adminNome = $_SESSION['nome'] ?? 'Administrador';
$adminEmail = $_SESSION['email'] ?? 'sem_email@dominio.com';

// --- Filtros da busca ---
$busca = $_GET['busca'] ?? '';
$ordem = $_GET['ordem'] ?? '';
$statusFiltro = $_GET['status'] ?? '';

$sql = "
    SELECT 
        a.id,
        u.cpf,
        CONCAT(u.nome, ' ', u.sobrenome) AS paciente,
        m.nome AS medico,
        e.nome AS especialidade,
        a.data_consulta,
        a.status
    FROM agendamentos a
    JOIN usuarios u ON a.cpf_paciente = u.cpf
    JOIN medicos m ON a.id_medico = m.id
    JOIN especialidades e ON a.id_especialidade = e.id
    WHERE 1=1
";

$params = [];
$types = "";

// --- Filtro de busca ---
if (!empty($busca)) {
    $buscaLimpa = preg_replace('/[.\-]/', '', $busca);
    $buscaLike = "%$busca%";
    $buscaLimpaLike = "%$buscaLimpa%";

    $sql .= " AND (
        u.nome LIKE ? OR
        u.sobrenome LIKE ? OR
        REPLACE(REPLACE(u.cpf, '.', ''), '-', '') LIKE ? OR
        u.email LIKE ? OR
        DATE_FORMAT(u.DataNascimento, '%d/%m/%Y') LIKE ? OR
        m.nome LIKE ? OR
        e.nome LIKE ?
    )";

    $params = array_merge($params, [
        $buscaLike, $buscaLike, $buscaLimpaLike,
        $buscaLike, $buscaLike, $buscaLike, $buscaLike
    ]);
    $types .= "sssssss";
}

// --- Filtro de status ---
if (!empty($statusFiltro)) {
    $sql .= " AND a.status = ?";
    $params[] = $statusFiltro;
    $types .= "s";
}

// --- Ordenação ---
switch ($ordem) {
    case 'alfabetica':
        $sql .= " ORDER BY u.nome ASC";
        break;
    case 'data':
        $sql .= " ORDER BY a.data_consulta DESC";
        break;
    default:
        $sql .= " ORDER BY a.data_consulta DESC";
}

$stmt = $conn->prepare($sql);
if ($types) $stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Lista de Agendamentos - Raízes da Saúde</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="css/admin.css">

<style>
body {
  background-color: #f8f9fa;
}
.table thead {
  background-color: #e9ecef;
}
.table-hover tbody tr:hover {
  background-color: #f1f1f1;
}
.status-pendente {
  background-color: #fff3cd;
  color: #856404;
  border-radius: 20px;
  padding: 4px 10px;
}
.status-confirmada {
  background-color: #d4edda;
  color: #155724;
  border-radius: 20px;
  padding: 4px 10px;
}
.status-cancelada {
  background-color: #f8d7da;
  color: #721c24;
  border-radius: 20px;
  padding: 4px 10px;
}
.status-realizada {
  background-color: #cce5ff;
  color: #004085;
  border-radius: 20px;
  padding: 4px 10px;
}
.status-nao_realizada {
  background-color: #e2e3e5;
  color: #383d41;
  border-radius: 20px;
  padding: 4px 10px;
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar p-3">
  <h3 class="mb-4 fw-bold">Raiz Saúde</h3>
  <nav class="nav flex-column">
    <a href="admin.php">Painel de Consultas</a>
    <a href="admin_cadastro.php">Cadastrar</a>
    <a href="criar_acesso.php">Criar Acesso</a>
    <a href="crud.php">Pacientes</a>
    <a href="consultas.php" class="nav-link"><i class="bi bi-calendar-check me-2"></i> Consultas</a>
    <a href="log.php">Relatórios</a>
    <a href="configuracoes.php">Configurações</a>
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
    </div>
  </nav>

<div class="container mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h3><strong>Lista de Agendamentos</strong></h3>
  </div>

  <form method="GET" class="mb-4 p-3 bg-white shadow-sm rounded-3">
  <div class="row g-3 align-items-center">

    <!-- Campo de busca -->
    <div class="col-md-4"> <input type="text" name="busca" class="form-control" placeholder="CPF, médico ou especialidade" value="<?= htmlspecialchars($busca) ?>"> </div>

    <!-- Ordenação -->
    <div class="col-lg-3 col-md-6 col-12">
      <select name="ordem" class="form-select">
        <option value="">Ordenar por...</option>
        <option value="alfabetica" <?= $ordem === 'alfabetica' ? 'selected' : '' ?>>Ordem Alfabética</option>
        <option value="data" <?= $ordem === 'data' ? 'selected' : '' ?>>Data da Consulta</option>
      </select>
    </div>

    <!-- Filtro por status -->
    <div class="col-lg-3 col-md-6 col-12">
      <select name="status" class="form-select">
        <option value="">Filtrar por Status...</option>
        <option value="pendente" <?= $statusFiltro === 'pendente' ? 'selected' : '' ?>>Pendente</option>
        <option value="confirmada" <?= $statusFiltro === 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
        <option value="cancelada" <?= $statusFiltro === 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
        <option value="realizada" <?= $statusFiltro === 'realizada' ? 'selected' : '' ?>>Realizada</option>
        <option value="nao_realizada" <?= $statusFiltro === 'nao_realizada' ? 'selected' : '' ?>>Não Realizada</option>
      </select>
    </div>

    <!-- Botões -->
    <div class="col-lg-2 col-md-6 col-12 text-lg-end text-md-end text-center d-flex justify-content-lg-end justify-content-center gap-2">
      <button type="submit" class="btn btn-success">
        <i class="bi bi-funnel"></i> Filtrar
      </button>
      <a href="<?= basename($_SERVER['PHP_SELF']) ?>" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-counterclockwise"></i>
      </a>
      <button type="button" onclick="baixarPDF()" class="btn btn-danger">
        <i class="bi bi-file-earmark-pdf-fill"></i>
      </button>
    </div>
  </div>
</form>



  <table class="table table-bordered table-hover align-middle shadow-sm">
    <thead class="table-light">
      <tr>
        <th>Paciente</th>
        <th>Doutor</th>
        <th>CPF</th>
        <th>Data</th>
        <th>Especialidade</th>
        <th>Status</th>
        <th>Ações</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['paciente']) ?></td>
            <td><?= htmlspecialchars($row['medico']) ?></td>
            <td><?= htmlspecialchars($row['cpf']) ?></td>
            <td><?= date('d/m/Y', strtotime($row['data_consulta'])) ?></td>
            <td><?= htmlspecialchars($row['especialidade']) ?></td>
            <td>
              <span class="status-<?= strtolower($row['status']) ?>">
                <?= ucfirst($row['status']) ?>
              </span>
            </td>
            <td>
              <a href="paciente_view.php?id=<?= $row['id']; ?>" class="btn btn-secondary btn-sm">
                <i class="bi bi-eye"></i> Visualizar
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr>
          <td colspan="7" class="text-center text-muted py-3">Nenhum agendamento encontrado.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<script src="js/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// === Função para gerar PDF ===
function baixarPDF() {
  const tabela = document.querySelector('table').outerHTML;
  const janela = window.open('', '', 'width=800,height=600');
  janela.document.write(`
    <html><head><title>Lista de Agendamentos</title>
    <style>
      body { font-family: Arial, sans-serif; margin: 20px; }
      h2 { text-align: center; }
      table { width: 100%; border-collapse: collapse; margin-top: 20px; }
      th, td { border: 1px solid #000; padding: 8px; text-align: center; }
      th { background-color: #f8f9fa; }
    </style>
    </head><body>
      <h2>Raiz Saúde - Lista de Agendamentos</h2>
      ${tabela}
    </body></html>
  `);
  janela.document.close();
  janela.print();
}
</script>

</body>
</html>
