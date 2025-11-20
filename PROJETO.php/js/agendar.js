$(document).ready(function () {

  // === Atualizar lista de médicos conforme especialidade ===
  $("#especialidade").on("change", function() {
    const idEspecialidade = $(this).val();

    $.get("get_medicos.php", { id_especialidade: idEspecialidade }, function(data) {
      $("#medico").html(data);
      $("#horario").html('<option value="">Selecione o médico primeiro</option>');
    });
  });

  // === Definir horários fixos ===
  $("#medico").on("change", function() {
    const horariosDisponiveis = [
      "08:00", "09:00", "10:00", "11:00",
      "13:00", "14:00", "15:00", "16:00"
    ];

    let options = "<option value=''>Selecione o horário</option>";
    $.each(horariosDisponiveis, function(_, hora) {
      options += `<option value="${hora}">${hora}</option>`;
    });

    $("#horario").html(options);
  });

  // === Máscara de CPF ===
  $('input[name="cpf"]').on('input', function() {
    let v = $(this).val().replace(/\D/g, ''); // Remove tudo que não é número
    if (v.length > 11) v = v.slice(0, 11);
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d)/, '$1.$2');
    v = v.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    $(this).val(v);
  });

  // === Máscara de Telefone ===
  $('input[name="telefone"]').on('input', function() {
    let v = $(this).val().replace(/\D/g, '');
    if (v.length > 11) v = v.slice(0, 11);
    v = v.replace(/^(\d{2})(\d)/g, '($1) $2');
    if (v.length > 10) {
      v = v.replace(/(\d{5})(\d{4})$/, '$1-$2');
    } else {
      v = v.replace(/(\d{4})(\d{4})$/, '$1-$2');
    }
    $(this).val(v);
  });


 // js/agendar.js
$(function () {
  // === Restrições no calendário ===
  const inputData = $('input[name="data"]');

  if (inputData.length === 0) {
    // se não encontrou o input, não segue (evita erro no console)
    console.warn('Input de data não encontrado: input[name="data"]');
    return;
  }

  // Define data mínima como amanhã (não pode hoje nem datas passadas)
  const hoje = new Date();
  hoje.setDate(hoje.getDate() + 1);
  const dataMinima = hoje.toISOString().split("T")[0];
  inputData.attr("min", dataMinima);

  // Bloqueia seleção de sábados e domingos
  inputData.on("input change", function () {
    const val = $(this).val();
    if (!val) return; // nada selecionado

    // Criar Date usando formato ISO para evitar problemas de timezone:
    const dataSelecionada = new Date(val + "T00:00:00");
    if (isNaN(dataSelecionada.getTime())) {
      // valor inválido (proteção extra)
      Swal.fire({
        icon: 'error',
        title: 'Data inválida',
        text: 'O valor de data selecionado não é válido. Tente novamente.',
        confirmButtonText: 'Ok'
      });
      $(this).val('');
      $(this).focus();
      return;
    }

    const diaSemana = dataSelecionada.getDay(); // 0 = domingo, 6 = sábado

    if (diaSemana === 0 || diaSemana === 6) {
      Swal.fire({
        icon: 'warning',
        title: 'Agendamento indisponível',
        text: 'Não é possível agendar consultas em finais de semana.',
        confirmButtonText: 'Entendi',
      });

      $(this).val("");
      $(this).focus();
    }
  });
});


});
