<?php
session_start();
include('conexao.php');

// Verifica se o usuário é admin
if (!isset($_SESSION['email']) || $_SESSION['tipo'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$adminNome = $_SESSION['nome'] ?? 'Administrador';
$adminEmail = $_SESSION['email'] ?? 'sem_email@dominio.com';
?>

<!doctype html>
<html lang="pt-br">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Lista de Usuários - Raízes da Saúde</title>

  <!-- Bootstrap e Ícones -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="css/admin.css">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar p-3">
  <h3 class="mb-4 fw-bold">Raiz Saúde</h3>
  <nav class="nav flex-column">
    <a href="admin.php">Painel de Consultas</a>
    <a href="admin_cadastro.php">Cadastrar</a>
    <a href="criar_acesso.php">Criar Acesso</a>
    <a href="crud.php" class="nav-link"><i class="bi bi-people me-2"></i> Pacientes</a>
    <a href="consultas.php">Consultas</a>
    <a href="log.php">Relatórios</a>
    <a href="configuracoes.php"> Configurações</a>
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

    <!-- Conteúdo -->
    <div class="container mt-4">
      <?php include('mensagem.php'); ?> 
      <div class="row">
        <div class="col-md-12">
          <div class="card shadow-sm">
            
            <!-- Cabeçalho -->
            <div class="card-header d-flex justify-content-between align-items-center flex-wrap gap-2">
              <h4 class="m-0">Lista de Usuários</h4>

              <div class="d-flex align-items-center gap-2 flex-wrap">
                <!-- Busca -->
                <form method="GET" class="d-flex align-items-center" role="search">
                  <input 
                    type="text" 
                    name="pesquisa" 
                    class="form-control me-2" 
                    placeholder="Buscar por CPF, Nome ou Data"
                    value="<?= isset($_GET['pesquisa']) ? htmlspecialchars($_GET['pesquisa']) : '' ?>"
                  >
                  <button type="submit" class="btn btn-outline-success me-2">
                    <i class="bi bi-search"></i>
                  </button>

                  <!-- Limpar busca -->
                  <?php if(!empty($_GET['pesquisa'])): ?>
                    <a href="crud.php" class="btn btn-outline-secondary me-2" title="Limpar busca">
                      <i class="bi bi-x-circle"></i>
                    </a>
                  <?php endif; ?>
                </form>

                <!-- Ordenar -->
                <a href="crud.php?ordem=asc" class="btn btn-outline-info me-2">
                  <i class="bi bi-sort-alpha-down"></i> A-Z
                </a>

                <!-- Baixar PDF -->
                <button onclick="baixarPDF()" class="btn btn-danger me-2">
                  <i class="bi bi-file-earmark-pdf-fill"></i> Baixar PDF
                </button>

                <!-- Novo Usuário -->
                <a href="admin_cadastro.php" class="btn btn-primary">Adicionar Usuário</a>
              </div>
            </div>

            <!-- Tabela -->
            <div class="card-body"> 
              <table class="table table-bordered table-striped align-middle">
                <thead class="table-light">
                  <tr>
                    <th>CPF</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Nascimento</th>
                    <th>Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    $pesquisa = $_GET['pesquisa'] ?? '';
                    $ordem = $_GET['ordem'] ?? '';

                    if ($pesquisa !== '') {
                        $pesquisa = mysqli_real_escape_string($conn, $pesquisa);
                        $sql = "SELECT * FROM usuarios 
                                WHERE nome LIKE '%$pesquisa%' 
                                OR cpf LIKE '%$pesquisa%' 
                                OR DataNascimento LIKE '%$pesquisa%'
                                ORDER BY nome ASC";
                    } elseif ($ordem == 'asc') {
                        $sql = "SELECT * FROM usuarios ORDER BY nome ASC";
                    } else {
                        $sql = "SELECT * FROM usuarios";
                    }

                    $usuarios = mysqli_query($conn, $sql);

                    if(mysqli_num_rows($usuarios) > 0):
                      foreach($usuarios as $usuario):
                  ?>
                  <tr>
                    <td><?= $usuario['cpf'] ?></td>
                    <td><?= $usuario['nome'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td><?= date('d/m/Y', strtotime($usuario['DataNascimento'])) ?></td>
                    <td>
                      <a href="usuario_view.php?cpf=<?= $usuario['cpf'] ?>" class="btn btn-secondary btn-sm">
                        <i class="bi bi-eye-fill"></i> Visualizar
                      </a>
                      <a href="usuario_edit.php?cpf=<?= $usuario['cpf'] ?>" class="btn btn-warning btn-sm text-white">
                        <i class="bi bi-pencil-fill"></i> Editar
                      </a>
                      <button type="button" class="btn btn-danger btn-sm delete-btn" data-cpf="<?= $usuario['cpf'] ?>">
                        <i class="bi bi-trash3-fill"></i> Excluir
                      </button>
                    </td>
                  </tr>
                  <?php
                      endforeach;
                    else:
                      echo "<tr><td colspan='5' class='text-center'>Nenhum usuário encontrado.</td></tr>";
                    endif;
                  ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>      
      </div>
    </div>
  </div>

  <!-- Scripts principais -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>

  <script>
  // === Função para gerar PDF ===
  function baixarPDF() {
    const tabela = document.querySelector('table').outerHTML;
    const janela = window.open('', '', 'width=800,height=600');
    janela.document.write(`
      <html><head><title>Lista de Pacientes</title>
      <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h2 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: center; }
        th { background-color: #f8f9fa; }
      </style>
      </head><body>
        <h2>Raiz Saúde - Lista de Pacientes</h2>
        ${tabela}
      </body></html>
    `);
    janela.document.close();
    janela.print();
  }

  // === Máscara automática para CPF ===
  document.addEventListener('DOMContentLoaded', function() {
    const inputPesquisa = document.querySelector('input[name="pesquisa"]');
    if (inputPesquisa) {
      inputPesquisa.addEventListener('input', function() {
        let valor = this.value.replace(/\D/g, '');
        if (valor.length > 11) valor = valor.substring(0, 11);
        if (valor.length > 9) {
          this.value = valor.replace(/(\d{3})(\d{3})(\d{3})(\d{1,2})/, '$1.$2.$3-$4');
        } else if (valor.length > 6) {
          this.value = valor.replace(/(\d{3})(\d{3})(\d{1,3})/, '$1.$2.$3');
        } else if (valor.length > 3) {
          this.value = valor.replace(/(\d{3})(\d{1,3})/, '$1.$2');
        } else {
          this.value = valor;
        }
      });
    }

    // === Confirmação de exclusão (SweetAlert2) ===
    document.querySelectorAll('.delete-btn').forEach(button => {
      button.addEventListener('click', function() {
        const cpf = this.getAttribute('data-cpf');
        Swal.fire({
          title: 'Tem certeza?',
          text: 'Essa ação não poderá ser desfeita!',
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#d33',
          cancelButtonColor: '#3085d6',
          confirmButtonText: 'Sim, excluir!',
          cancelButtonText: 'Cancelar'
        }).then((result) => {
          if (result.isConfirmed) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'acoes.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_usuario';
            input.value = cpf;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
          }
        });
      });
    });
  });
  </script>

  <!-- Mensagem de sucesso -->
  <?php if(isset($_SESSION['mensagem'])): ?>
  <script>
  Swal.fire({
    title: 'Aviso',
    text: '<?= $_SESSION['mensagem']; ?>',
    icon: 'success',
    confirmButtonText: 'OK'
  });
  </script>
  <?php unset($_SESSION['mensagem']); endif; ?>

  <script src="js/admin.js"></script>

</body>
</html>
