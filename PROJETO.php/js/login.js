// login.js
// Exibir/ocultar senha + mensagens de erro (Raízes da Saúde ✨)

document.addEventListener("DOMContentLoaded", function () {
  // === EXIBIR / OCULTAR SENHA ===
  const campoSenha = document.getElementById("idSenha");
  const botaoExibir = document.getElementById("btn-exibirSenha");

  if (campoSenha && botaoExibir) {
    botaoExibir.addEventListener("click", function () {
      if (campoSenha.type === "password") {
        campoSenha.type = "text";
        botaoExibir.classList.remove("bi-eye-fill");
        botaoExibir.classList.add("bi-eye-slash-fill");
        botaoExibir.title = "Ocultar senha";
      } else {
        campoSenha.type = "password";
        botaoExibir.classList.remove("bi-eye-slash-fill");
        botaoExibir.classList.add("bi-eye-fill");
        botaoExibir.title = "Mostrar senha";
      }
    });
  }

  // === MOSTRAR MENSAGENS DE ERRO ===
  const params = new URLSearchParams(window.location.search);
  const erro = params.get("erro");

  if (erro === "email") {
    const emailInput = document.getElementById("idEmail");
    if (emailInput) {
      const msgErro = document.createElement("small");
      msgErro.textContent = "E-mail não cadastrado";
      msgErro.classList.add("msg-erro");
      emailInput.classList.add("erro");
      emailInput.insertAdjacentElement("afterend", msgErro);
    }
  }

  if (erro === "senha") {
    const senhaInput = document.getElementById("idSenha");
    const botaoExibir = document.getElementById("btn-exibirSenha");

    if (senhaInput) {
      const msgErro = document.createElement("small");
      msgErro.textContent = "Senha incorreta";
      msgErro.classList.add("msg-erro");
      senhaInput.classList.add("erro");
      senhaInput.insertAdjacentElement("afterend", msgErro);
    }

    // 👉 Ajustar posição do olhinho quando há erro
    if (botaoExibir) {
      botaoExibir.classList.add("erro-posicao");
    }
  } else {
    // 👉 Remover ajuste se não houver erro de senha
    const botaoExibir = document.getElementById("btn-exibirSenha");
    if (botaoExibir) {
      botaoExibir.classList.remove("erro-posicao");
    }
  }
});
