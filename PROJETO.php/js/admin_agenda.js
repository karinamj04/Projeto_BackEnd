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


    // === Restrições no calendário ===
    const inputData = $('input[name="data"]');

    // Define data mínima como amanhã (não pode hoje nem datas passadas)
    const hoje = new Date();
    hoje.setDate(hoje.getDate() + 1);
    const dataMinima = hoje.toISOString().split("T")[0];
    inputData.attr("min", dataMinima);

    // Bloqueia seleção de sábados e domingos
    inputData.on("input", function () {
      const dataSelecionada = new Date($(this).val() + "T00:00:00");
      const diaSemana = dataSelecionada.getDay(); // 0 = domingo, 6 = sábado

      if (diaSemana === 0 || diaSemana === 6) {
        alert(" Não é possível agendar consultas em finais de semana.");
        $(this).val("");
      }
    });

  });
