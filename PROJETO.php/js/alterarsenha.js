// Espera o carregamento completo do HTML

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("form-alterar-senha");
  const feedback = document.getElementById("feedback");
  const cpfInput = document.getElementById("cpf");

  // Máscara de CPF — adiciona os pontos e o traço automaticamente
  cpfInput.addEventListener("input", (e) => {
    let value = e.target.value.replace(/\D/g, ""); // remove tudo que não é número
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d)/, "$1.$2");
    value = value.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
    e.target.value = value;
  });

  // Evento ao enviar o formulário
  form.addEventListener("submit", async (e) => {
    e.preventDefault();

    const cpf = cpfInput.value.trim();
    const novaSenha = document.getElementById("novaSenha").value.trim();
    const confirmarSenha = document.getElementById("confirmarSenha").value.trim();

    // Limpa mensagens anteriores
    feedback.textContent = "Processando...";
    feedback.classList.remove("text-success", "text-warning");
    feedback.classList.add("text-light");

    try {
      // Envia dados ao PHP
      const resposta = await fetch("processa_alterar_senha.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: new URLSearchParams({ cpf, novaSenha, confirmarSenha }),
      });

      const dados = await resposta.json();

      // Mostra mensagem vinda do PHP
      feedback.textContent = dados.mensagem;

      if (dados.ok) {
        feedback.classList.remove("text-warning");
        feedback.classList.add("text-success");
        form.reset();

        // Redireciona para login após 2 segundos
        setTimeout(() => {
          window.location.href = "login.php";
        }, 2000);
      } else {
        feedback.classList.remove("text-success");
        feedback.classList.add("text-warning");
      }
    } catch (erro) {
      console.error("Erro:", erro);
      feedback.textContent = "Erro de conexão. Tente novamente.";
      feedback.classList.remove("text-success");
      feedback.classList.add("text-warning");
    }
  });
});

