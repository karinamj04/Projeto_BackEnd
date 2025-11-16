document.addEventListener("DOMContentLoaded", () => {
  const container = document.getElementById("agendamentos-container");
  const semAgendamentos = document.getElementById("sem-agendamentos");

  let agendamentos = JSON.parse(localStorage.getItem("agendamentos")) || [];

  // Filtra agendamentos inválidos
  agendamentos = agendamentos.filter(a => 
    a && a.nome && a.cpf && a.data && a.especialidade && a.medico && a.horario
  );

  // Atualiza localStorage
  localStorage.setItem("agendamentos", JSON.stringify(agendamentos));

  if (agendamentos.length === 0) {
    semAgendamentos.style.display = "block";
  } else {
    agendamentos.forEach((agendamento, index) => {
      const card = document.createElement("div");
      card.className = "card";

      // Se confirmado, adiciona a classe de cor verde suave
      if (agendamento.confirmado) {
        card.classList.add("confirmado");
      }

      card.innerHTML = `
        <p><strong>Nome:</strong> ${agendamento.nome}</p>
        <p><strong>CPF:</strong> ${agendamento.cpf}</p>
        <p><strong>Data:</strong> ${agendamento.data}</p>
        <p><strong>Especialidade:</strong> ${agendamento.especialidade}</p>
        <p><strong>Médico:</strong> ${agendamento.medico}</p>
        <p><strong>Horário:</strong> ${agendamento.horario}</p>
        <div class="botoes">
          <button class="confirmar">Confirmar</button>
          <button class="cancelar">Cancelar</button>
          <button  id="sair" class="sair">Sair</button>
        </div>
      `;

      const confirmarBtn = card.querySelector(".confirmar");
      const cancelarBtn = card.querySelector(".cancelar");

      confirmarBtn.addEventListener("click", () => {
        agendamento.confirmado = true; // Marca como confirmado
        localStorage.setItem("agendamentos", JSON.stringify(agendamentos));
        card.classList.add("confirmado"); // Adiciona a cor verde suave
      });

      cancelarBtn.addEventListener("click", () => {
        if (confirm("Tem certeza que deseja cancelar este agendamento?")) {
          agendamentos.splice(index, 1);
          localStorage.setItem("agendamentos", JSON.stringify(agendamentos));
          location.reload();
        }
      });

      container.appendChild(card);
    });
  }
});
document.addEventListener("DOMContentLoaded", function () {
      // Seleciona o botão pelo ID
      const botao = document.getElementById("sair");

      // Adiciona o evento de clique
      botao.addEventListener("click", function () {
        // Redireciona para a outra página
        window.location.href = "sistema.php";
      });
    });