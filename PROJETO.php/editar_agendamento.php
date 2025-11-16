<?php
// editar_agendamento.php
include 'conexao.php';
session_start();

// Verifica se o ID do agendamento foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: historico.php");
    exit;
}

$id = intval($_GET['id']);

// Busca os dados do agendamento
$sql = "SELECT * FROM agendamentos WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: historico.php");
    exit;
}

$agendamento = $result->fetch_assoc();

// Processa o POST (salvar alterações)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $cpf_paciente = trim($_POST['cpf_paciente'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $id_especialidade = intval($_POST['id_especialidade'] ?? 0);
    $id_medico = intval($_POST['id_medico'] ?? 0);
    $data_consulta = trim($_POST['data_consulta'] ?? '');
    $horario = trim($_POST['horario'] ?? '');

    if ($nome === '' || $email === '' || $cpf_paciente === '' || $telefone === '' ||
        $id_especialidade <= 0 || $id_medico <= 0 || $data_consulta === '' || $horario === '') {
        $erro_msg = "Por favor, preencha todos os campos corretamente.";
    } else {
        $sql_update = "UPDATE agendamentos
                       SET nome = ?, email = ?, cpf_paciente = ?, telefone = ?, 
                           id_especialidade = ?, id_medico = ?, data_consulta = ?, horario = ?
                       WHERE id = ?";
        $stmt_up = $conn->prepare($sql_update);
        $stmt_up->bind_param("ssssiissi", $nome, $email, $cpf_paciente, $telefone, $id_especialidade, $id_medico, $data_consulta, $horario, $id);

        if ($stmt_up->execute()) {
            header("Location: historico.php?atualizado=1");
            exit;
        } else {
            $erro_msg = "Erro ao atualizar: " . $stmt_up->error;
        }
    }
}

// Buscar especialidades para o select
$sqlEsp = "SELECT id, nome FROM especialidades ORDER BY nome";
$resEsp = $conn->query($sqlEsp);

// Valor do médico atual para o JS pré-selecionar
$medico_atual = intval($agendamento['id_medico']);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Editar Agendamento - Raízes da Saúde </title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<style>
  body { background: #f8f9fa; font-family: Arial, sans-serif; }
  .card { max-width: 720px; margin: 40px auto; border-radius: 10px; }
</style>
</head>
<body>
<div class="card p-4 shadow">
<h3 class="mb-4">Editar Agendamento</h3>

<?php if (!empty($erro_msg)): ?>
  <div class="alert alert-danger"><?php echo htmlspecialchars($erro_msg); ?></div>
<?php endif; ?>

<form method="POST" autocomplete="off">
  <div class="row">
    <div class="mb-3 col-12">
      <label class="form-label">Nome</label>
      <input type="text" name="nome" class="form-control" value="<?php echo htmlspecialchars($agendamento['nome']); ?>" required>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($agendamento['email']); ?>" required>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">CPF</label>
      <input type="text" name="cpf_paciente" class="form-control" value="<?php echo htmlspecialchars($agendamento['cpf_paciente']); ?>" required>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">Telefone</label>
      <input type="text" name="telefone" class="form-control" value="<?php echo htmlspecialchars($agendamento['telefone']); ?>" required>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">Especialidade</label>
      <select name="id_especialidade" id="especialidade" class="form-select" required>
        <option value="">Selecione</option>
        <?php while ($esp = $resEsp->fetch_assoc()): 
          $sel = ($esp['id'] == $agendamento['id_especialidade']) ? 'selected' : '';
        ?>
          <option value="<?php echo $esp['id']; ?>" <?php echo $sel; ?>>
            <?php echo htmlspecialchars($esp['nome']); ?>
          </option>
        <?php endwhile; ?>
      </select>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">Médico</label>
      <select name="id_medico" id="medico" class="form-select" required>
        <option value="">Selecione a especialidade primeiro</option>
      </select>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">Data da Consulta</label>
      <input type="date" name="data_consulta" class="form-control" value="<?php echo htmlspecialchars($agendamento['data_consulta']); ?>" required>
    </div>

    <div class="mb-3 col-md-6">
      <label class="form-label">Horário</label>
      <select name="horario" id="horario" class="form-select" required>
        <option value="">Selecione o médico primeiro</option>
      </select>
    </div>
  </div>

  <div class="d-grid gap-2">
    <button class="btn btn-success">Salvar Alterações</button>
    <a href="historico.php" class="btn btn-secondary">Voltar</a>
  </div>
</form>
</div>

<script>
$(document).ready(function() {
  const horariosFixos = ["08:00","09:00","10:00","11:00","13:00","14:00","15:00","16:00"];
  const $dataConsulta = $('input[name="data_consulta"]');

  // Impede seleção de finais de semana e dias anteriores
  function restringirDatas() {
    const hoje = new Date().toISOString().split("T")[0];
    $dataConsulta.attr("min", hoje);

    $dataConsulta.on("change", function() {
      const data = new Date($(this).val());
      const diaSemana = data.getUTCDay(); // 0 = domingo, 6 = sábado

      if (diaSemana === 0 || diaSemana === 6) {
        $(this).val("");
        $(this).addClass("is-invalid");
        if (!$('#erroData').length) {
          $(this).after('<div id="erroData" class="text-danger mt-1">Não é permitido agendar finais de semana.</div>');
        }
      } else {
        $(this).removeClass("is-invalid");
        $('#erroData').remove();
      }
    });
  }

  // Atualiza lista de horários
  function atualizarHorarios(horarioAtual = null) {
    const medicoSelecionado = $('#medico').val();
    const $horario = $('#horario');

    if (!medicoSelecionado) {
      $horario.html('<option value="">Selecione o médico primeiro</option>').prop('disabled', true);
      return;
    }

    let options = '<option value="">Selecione</option>';
    horariosFixos.forEach(h => {
      options += `<option value="${h}" ${h === horarioAtual ? 'selected' : ''}>${h}</option>`;
    });

    $horario.html(options).prop('disabled', false);
  }

  // Carrega médicos via AJAX
  function carregarMedicos(idEspecialidade, medicoSelecionado = null) {
    if (!idEspecialidade) {
      $('#medico').html('<option value="">Selecione a especialidade primeiro</option>');
      return;
    }
    $.get('get_medicos.php', { id_especialidade: idEspecialidade }, function(html) {
      $('#medico').html(html);
      if (medicoSelecionado) {
        $('#medico').val(medicoSelecionado);
      }
      atualizarHorarios();
    }).fail(function() {
      $('#medico').html('<option value="">Erro ao carregar médicos</option>');
    });
  }

  // Eventos
  $('#especialidade').on('change', function() {
    var idEsp = $(this).val();
    $('#horario').html('<option value="">Selecione o médico primeiro</option>').prop('disabled', true);
    carregarMedicos(idEsp, null);
  });

  $('#medico').on('change', function() {
    atualizarHorarios();
  });

  // Inicializa valores
  const especialidadeAtual = $('#especialidade').val();
  const medicoAtual = <?php echo json_encode($medico_atual); ?>;
  const horarioAtual = <?php echo json_encode($agendamento['horario']); ?>;

  if (especialidadeAtual) {
    carregarMedicos(especialidadeAtual, medicoAtual);
    atualizarHorarios(horarioAtual);
  } else {
    atualizarHorarios();
  }

  // Chama função de restrição de datas
  restringirDatas();
});
</script>

</body>
</html>
