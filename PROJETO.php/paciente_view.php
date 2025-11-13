<?php
session_start();
include('conexao.php');

// Verifica se o usuário está logado e é admin
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
  <title>Agendamento - Visualizar - Raízes da Saúde </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    .msg-temporaria {
      display: block;
      margin-top: 8px;
      font-weight: 500;
      color: #155724;
      background-color: #d4edda;
      border: 1px solid #c3e6cb;
      padding: 6px 10px;
      border-radius: 5px;
      font-size: 0.9rem;
      max-width: 300px;
      transition: opacity 0.5s ease;
    }
    .msg-erro {
      background-color: #f8d7da;
      border-color: #f5c6cb;
      color: #721c24;
    }

    /* Estilo da janela de confirmação */
    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background-color: rgba(0,0,0,0.6);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .caixa-confirmacao {
      background: #fff;
      padding: 20px 30px;
      border-radius: 10px;
      text-align: center;
      box-shadow: 0 4px 12px rgba(0,0,0,0.3);
      max-width: 350px;
    }
    .caixa-confirmacao h5 {
      margin-bottom: 15px;
      color: #333;
    }
  </style>

  <script>
    function alterarStatus(id, acao, btn) {
      // Caso o usuário clique em "Cancelar", mostramos a janela de confirmação
      if (acao === 'cancelar') {
        exibirConfirmacao(id, acao, btn);
        return;
      }

      // Executa a atualização do status
      atualizarStatus(id, acao, btn);
    }

    // Função responsável por fazer o fetch e atualizar o status
    function atualizarStatus(id, acao, btn) {
      btn.disabled = true; // impede clique duplo
      const msg = document.getElementById('msg-' + id);
      msg.textContent = "Atualizando...";
      msg.classList.remove('msg-erro');
      msg.style.opacity = 1;

      fetch('acao_agendamento.php?id=' + id + '&acao=' + acao)
        .then(response => response.text())
        .then(data => {
          if (data.startsWith('erro')) {
              msg.textContent = "Falha ao atualizar o status.";
              msg.classList.add('msg-erro');
          } else {
              msg.textContent = "Status atualizado para: " + data;
              msg.classList.remove('msg-erro');
              document.getElementById('status-' + id).textContent =
                data.charAt(0).toUpperCase() + data.slice(1);

              // Aguarda 1 segundo e recarrega automaticamente
              setTimeout(() => location.reload(), 1000);
          }
        })
        .catch(() => {
          msg.textContent = "Erro de conexão.";
          msg.classList.add('msg-erro');
        })
        .finally(() => btn.disabled = false);
    }

    // Função para exibir a janela de confirmação personalizada
    function exibirConfirmacao(id, acao, btn) {
      const overlay = document.getElementById('overlay-confirmacao');
      overlay.style.display = 'flex';

      const confirmarBtn = document.getElementById('confirmar-cancelamento');
      const cancelarBtn = document.getElementById('fechar-confirmacao');

      confirmarBtn.onclick = () => {
        overlay.style.display = 'none';
        atualizarStatus(id, acao, btn);
      };

      cancelarBtn.onclick = () => {
        overlay.style.display = 'none';
      };
    }
  </script>
</head>
<body>
<div class='container mt-5'>
  <div class='row'>
    <div class='col-md-12'>
      <div class='card'>
        <div class='card-header'>
          <h4>Visualizar Agendamento
            <a href='consultas.php' class='btn btn-danger float-end'>VOLTAR</a>
          </h4>
        </div>
        <div class='card-body'>
          <?php
          if (isset($_GET['id'])) {
              $id = intval($_GET['id']);

              $sql = "
                SELECT a.*, 
                       u.nome AS nome_paciente, u.email AS email_paciente, u.telefoneCelular AS telefone_paciente,
                       m.nome AS nome_medico,
                       e.nome AS especialidade
                FROM agendamentos a
                JOIN usuarios u ON a.cpf_paciente = u.cpf
                JOIN medicos m ON a.id_medico = m.id
                JOIN especialidades e ON m.id_especialidade = e.id
                WHERE a.id = $id
              ";
              
              $query = mysqli_query($conn, $sql);

              if (mysqli_num_rows($query) > 0) {
                  $agendamento = mysqli_fetch_assoc($query);
                  $status = strtolower(trim($agendamento['status']));
          ?>
            <div class="mb-3">
              <label><strong>Paciente</strong></label>
              <p class="form-control"><?= htmlspecialchars($agendamento['nome_paciente']); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Email</strong></label>
              <p class="form-control"><?= htmlspecialchars($agendamento['email_paciente']); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Telefone</strong></label>
              <p class="form-control"><?= htmlspecialchars($agendamento['telefone_paciente']); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Data da Consulta</strong></label>
              <p class="form-control"><?= date('d/m/Y', strtotime($agendamento['data_consulta'])); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Horário</strong></label>
              <p class="form-control"><?= date('H:i', strtotime($agendamento['horario'])); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Status</strong></label>
              <p id="status-<?= $agendamento['id']; ?>" class="form-control text-capitalize">
                <?= htmlspecialchars($status); ?>
              </p>
            </div>

            <div class="mb-3">
              <label><strong>Médico</strong></label>
              <p class="form-control"><?= htmlspecialchars($agendamento['nome_medico']); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Especialidade</strong></label>
              <p class="form-control"><?= htmlspecialchars($agendamento['especialidade']); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Registrado em</strong></label>
              <p class="form-control"><?= date('d/m/Y H:i', strtotime($agendamento['criado_em'])); ?></p>
            </div>

            <div class="mb-3">
              <label><strong>Ações do Administrador</strong></label><br>

              <?php
              $status = $agendamento['status'];

              if ($status === 'pendente') {
              ?>
                <button class="btn btn-success btn-sm"
                        onclick="alterarStatus(<?= $agendamento['id']; ?>, 'confirmar', this)">
                  Confirmar
                </button>
                <button class="btn btn-danger btn-sm"
                        onclick="alterarStatus(<?= $agendamento['id']; ?>, 'cancelar', this)">
                  Cancelar
                </button>

              <?php } elseif ($status === 'confirmada') { ?>
                <button class="btn btn-primary btn-sm"
                        onclick="alterarStatus(<?= $agendamento['id']; ?>, 'realizada', this)">
                  Paciente Compareceu
                </button>
                <button class="btn btn-warning btn-sm text-dark"
                        onclick="alterarStatus(<?= $agendamento['id']; ?>, 'nao_realizada', this)">
                  Paciente Não Compareceu
                </button>

              <?php } elseif ($status === 'cancelada') { ?>
                <span class="text-danger fw-bold">Cancelada</span>

              <?php } elseif ($status === 'realizada') { ?>
                <span class="text-success fw-bold">Consulta Realizada</span>

              <?php } elseif ($status === 'nao_realizada') { ?>
                <span class="text-warning fw-bold">Consulta Não Realizada</span>
              <?php } ?>

              <span class="msg-temporaria" id="msg-<?= $agendamento['id']; ?>"></span>
            </div>

          <?php
              } else {
                  echo "<h5>Nenhum agendamento encontrado para este ID.</h5>";
              }
          } else {
              echo "<h5>ID do agendamento não informado.</h5>";
          }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Caixa de confirmação sem alert -->
<div id="overlay-confirmacao" class="overlay">
  <div class="caixa-confirmacao">
    <h5>Tem certeza que deseja cancelar esta consulta?</h5>
    <div class="d-flex justify-content-center gap-2">
      <button id="confirmar-cancelamento" class="btn btn-danger">Sim, cancelar</button>
      <button id="fechar-confirmacao" class="btn btn-secondary">Voltar</button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
