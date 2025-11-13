// Máscara de CPF
document.getElementById('cpf').addEventListener('input', function (e) {
  let value = e.target.value.replace(/\D/g, '');
  value = value.replace(/(\d{3})(\d)/, '$1.$2');
  value = value.replace(/(\d{3})(\d)/, '$1.$2');
  value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
  e.target.value = value;
});

// Lógica de verificação de CPF
document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("formCpf");
  const mensagem = document.getElementById("mensagem");

  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const cpf = document.getElementById("cpf").value.trim();

    if (!cpf) {
      mensagem.textContent = "Por favor, digite seu CPF.";
      mensagem.classList.remove("text-success");
      mensagem.classList.add("text-warning");
      return;
    }

    try {
      const resposta = await fetch("verificar_cpf.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: `cpf=${encodeURIComponent(cpf)}`,
      });

      const dados = await resposta.json();

      if (dados.ok && dados.existe) {
        mensagem.textContent = "CPF encontrado! Redirecionando...";
        mensagem.classList.remove("text-warning");
        mensagem.classList.add("text-success");

        // Redireciona para alterar senha após 1.5s
        setTimeout(() => {
          window.location.href = "alterarSenha.php";
        }, 1500);
      } else {
        mensagem.textContent = "CPF não encontrado. Verifique e tente novamente.";
        mensagem.classList.remove("text-success");
        mensagem.classList.add("text-warning");
      }
    } catch (erro) {
      console.error("Erro na verificação:", erro);
      mensagem.textContent = "Erro ao verificar CPF. Tente novamente mais tarde.";
      mensagem.classList.remove("text-success");
      mensagem.classList.add("text-warning");
    }
  });
});
