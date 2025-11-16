const perguntas = [
  "Qual o nome da sua mãe?",
  "Qual a data do seu nascimento?",
  "Qual o CEP do seu endereço?"
];

let perguntaAtual = perguntas[Math.floor(Math.random() * perguntas.length)];
document.getElementById("pergunta").innerText = perguntaAtual;

let tentativas = 0;

document.getElementById("form2fa").addEventListener("submit", function (e) {
  e.preventDefault();

  const resposta = document.getElementById("resposta").value.trim();
  const feedback = document.getElementById("feedback");

  if (resposta === "") {
    feedback.innerText = "Por favor, preencha a resposta.";
    return;
  }

  const respostaCorreta = "teste";

  if (resposta.toLowerCase() === respostaCorreta.toLowerCase()) {
    feedback.classList.remove("text-warning", "text-danger");
    feedback.classList.add("text-success");
    feedback.innerText = "✅ Resposta correta! Redirecionando...";
    setTimeout(() => {
      window.location.href = "home.php";
    }, 1500);
    
  } else {
    tentativas++;
    if (tentativas >= 3) {
      feedback.classList.remove("text-success", "text-warning");
      feedback.classList.add("text-danger");
      feedback.innerText = "3 tentativas sem sucesso! Redirecionando para o cadastro...";
      setTimeout(() => {
        window.location.href = "cadastro.php";
      }, 5000);
      
    } else {
      feedback.classList.remove("text-success", "text-danger");
      feedback.classList.add("text-warning");
      feedback.innerText = `Resposta incorreta. Tentativa ${tentativas}/3.`;
      document.getElementById("resposta").value = "";
    }
  }
});

