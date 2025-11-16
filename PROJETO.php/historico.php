<?php
session_start();
include 'conexao.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

$email = $conn->real_escape_string($_SESSION['email']);

$sql = "
  SELECT a.*, e.nome AS especialidade_nome, m.nome AS medico_nome
  FROM agendamentos a
  LEFT JOIN especialidades e ON a.id_especialidade = e.id
  LEFT JOIN medicos m ON a.id_medico = m.id
  WHERE a.email = '$email'
  ORDER BY a.data_consulta DESC
";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Histórico de Consultas - Raízes da Saúde </title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <style>
    /* ====== Cores e Status ====== */
    .status-text {
      font-weight: 600;
      text-transform: capitalize;
      padding: 6px 10px;
      border-radius: 15px;
      display: inline-block;
      font-size: 0.9rem;
    }

    .status-pendente {
      background-color: #fff3cd;
      color: #856404;
    }
    .status-confirmada {
      background-color: #d4edda;
      color: #155724;
    }
    .status-cancelada {
      background-color: #f8d7da;
      color: #721c24;
    }
    .status-realizada {
      background-color: #c3e6cb;
      color: #155724;
    }
    .status-nao-realizada {
      background-color: #ffeeba;
      color: #856404;
    }

    /* ====== Mensagens temporárias ====== */
    .msg-temporaria {
      display: inline-block;
      margin-left: 10px;
      padding: 3px 8px;
      border-radius: 5px;
      font-size: 0.9em;
      color: #fff;
      background-color: #28a745;
      opacity: 0;
      transition: opacity 0.5s;
    }
    .msg-temporaria.show { opacity: 1; }

    /* ====== Outras configurações ====== */
    .linha-confirmada { background-color: #f6fff6 !important; }
    .linha-cancelada { background-color: #fff5f5 !important; }
    .btn-voltar {
      position: absolute;
      top: 15px;
      right: 15px;
      font-size: 1.3rem;
      color: #dc3545;
    }
    .card-header { position: relative; }
    .confirm-box {
      display: inline-block;
      margin-left: 5px;
    }
  </style>
</head>
<body>
  <div class="container mt-5 mb-5">
    <div class="card p-4 position-relative shadow-sm">
      <a href="sistema.php" class="btn btn-voltar" title="Voltar"><i class="bi bi-x-circle-fill"></i></a>
      <h2 class="text-center fw-bold mb-4">Histórico de Consultas</h2>

      <?php if ($result && $result->num_rows > 0) { ?>
        <div class="table-responsive">
          <table class="table table-hover align-middle text-center" id="tabelaConsultas">
            <thead class="table-light">
              <tr>
                <th>Data</th>
                <th>Horário</th>
                <th>Especialidade</th>
                <th>Médico</th>
                <th>Status</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <?php while ($row = $result->fetch_assoc()) {
                $id = (int) $row['id'];
                $status = strtolower(trim($row['status']));

                // Formata o status para exibição bonita
                $statusFormatado = ucfirst(str_replace('_', ' ', $status));

                // Define a classe CSS de acordo com o status
                $classeStatus = 'status-' . str_replace('_', '-', $status);
                $classeLinha = $status === 'confirmada' ? 'linha-confirmada' :
                              ($status === 'cancelada' ? 'linha-cancelada' : '');
              ?>
                <tr id="linha-<?php echo $id; ?>" class="<?php echo $classeLinha; ?>">
                  <td><?php echo date('d/m/Y', strtotime($row['data_consulta'])); ?></td>
                  <td><?php echo date('H:i', strtotime($row['horario'])); ?></td>
                  <td><?php echo htmlspecialchars($row['especialidade_nome']); ?></td>
                  <td><?php echo htmlspecialchars($row['medico_nome']); ?></td>
                  <td><span id="status-<?php echo $id; ?>" class="status-text <?php echo $classeStatus; ?>"><?php echo htmlspecialchars($statusFormatado); ?></span></td>
                  <td>
                    <?php if ($status === 'pendente') { ?>
                      <button class="btn btn-sm btn-success btn-acao" onclick="alterarStatus(<?php echo $id; ?>, 'confirmada')">Confirmar</button>
                      <button class="btn btn-sm btn-warning btn-acao" onclick="editarConsulta(<?php echo $id; ?>)">Editar</button>
                      <button class="btn btn-sm btn-danger btn-acao" onclick="mostrarConfirmacao(<?php echo $id; ?>)">Cancelar</button>
                    <?php } elseif ($status === 'confirmada') { ?>
                      <span class="text-success fw-bold">Confirmada</span>
                    <?php } elseif ($status === 'realizada') { ?>
                      <span class="text-success fw-bold">Realizada</span>
                    <?php } elseif ($status === 'nao_realizada') { ?>
                      <span class="text-warning fw-bold">Não Realizada</span>
                    <?php } else { ?>
                      <span class="text-danger fw-bold">Cancelada</span>
                    <?php } ?>
                    <span class="msg-temporaria" id="msg-<?php echo $id; ?>"></span>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      <?php } else { ?>
        <p class="text-center text-muted">Você ainda não possui consultas agendadas.</p>
      <?php } ?>
    </div>
  </div>

  <script>
    function mostrarMensagem(id, texto, sucesso = true) {
      const msg = document.getElementById('msg-' + id);
      msg.textContent = texto;
      msg.style.backgroundColor = sucesso ? '#28a745' : '#dc3545';
      msg.classList.add('show');
      setTimeout(() => msg.classList.remove('show'), 3000);
    }

    function alterarStatus(id, novoStatus) {
  fetch('alterar_status.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'id=' + encodeURIComponent(id) + '&status=' + encodeURIComponent(novoStatus)
  })
  .then(response => response.text())
  .then(data => {
    if (data.trim() === 'ok') {
      // Atualiza visualmente e recarrega com atraso suave
      mostrarMensagem(id, `Consulta ${novoStatus.replace('_', ' ')}!`);
      
      // Dá 1 segundo para mostrar a mensagem antes de atualizar
      setTimeout(() => {
        location.reload();
      }, 1000);
    } else {
      mostrarMensagem(id, 'Erro ao atualizar status.', false);
    }
  })
  .catch(() => mostrarMensagem(id, 'Erro de comunicação.', false));
}


    function mostrarConfirmacao(id) {
      const linha = document.getElementById('linha-' + id);
      if (document.getElementById('confirm-box-' + id)) return;

      const box = document.createElement('div');
      box.id = 'confirm-box-' + id;
      box.className = 'confirm-box';
      box.innerHTML = `
        <span>Tem certeza?</span>
        <button class="btn btn-sm btn-success ms-2">Sim</button>
        <button class="btn btn-sm btn-secondary ms-1">Não</button>
      `;
      linha.querySelector('td:last-child').appendChild(box);

      box.querySelector('button.btn-success').addEventListener('click', () => {
        alterarStatus(id, 'cancelada');
        box.remove();
      });

      box.querySelector('button.btn-secondary').addEventListener('click', () => box.remove());
    }

    // Função de redirecionamento para edição
    function editarConsulta(id) {
      window.location.href = 'editar_agendamento.php?id=' + id;
    }
  </script>
</body>
</html>
