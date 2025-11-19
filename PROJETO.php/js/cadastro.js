// Executa tudo apenas após o DOM estar completamente carregado
$(document).ready(function () {
  const $form = $("#formCadastro");
  const $mensagensErro = $("#mensagensErro");

  // ----------------- ALERTA CPF DUPLICADO -----------------
  const alerta = document.getElementById("alertapersonalizado");
  const botao = document.getElementById("alertbotao");

  if (alerta && botao) {
    // Botão OK
    botao.addEventListener("click", () => {
      fecharAlerta();
    });

    // Fechar automático após 3s
    setTimeout(() => {
      fecharAlerta();
    }, 10000);
  }

  function fecharAlerta() {
    const alerta = document.getElementById("alertapersonalizado");
    if (!alerta) return;

    alerta.classList.remove("active");

    // Remove completamente
    setTimeout(() => {
      alerta.remove();
    }, 400);

    // Remove erro da URL
    window.history.replaceState(null, "", "cadastro.php");
  }
  // ---------------------------------------------------------


  // --------------------------------------------------------------------
  // 🔧 Função auxiliar: mostra mensagem de erro abaixo do campo específico
  // --------------------------------------------------------------------
  function mostrarErroCampo(campoId, mensagem) {
    const $el = $(`#erro${campoId}`);
    if ($el.length) {
      $el.text(mensagem).addClass("fade-in-erromsg");
    }

    // Tabela de correspondência entre IDs de campo e os elementos reais
    const lookup = {
      Nome: "idNome", Sobrenome: "idSobrenome", NomeMaterno: "idnomeMaterno",
      Cpf: "idCpf", Cep: "cep", Endereco: "rua", Bairro: "bairro",
      Estado: "uf", Cidade: "cidade", Email: "email", Telefone: "telefone",
      Senha: "senha", ConfirmaSenha: "confirmaSenha"
    };

    const idCampo = lookup[campoId];
    const $input = idCampo ? $(`#${idCampo}`) : $();

    // Adiciona uma leve piscada no campo com erro
    if ($input.length) {
      $input.addClass("campo-erro");
      setTimeout(() => $input.removeClass("campo-erro"), 4000);
    }
  }

  // --------------------------------------------------------------------
  // 🧹 Limpa mensagens de erro antes de nova validação
  // --------------------------------------------------------------------
  function limparErrosCampos() {
    $(".erro-msg").text("").removeClass("fade-in-erromsg");
    $mensagensErro.addClass("d-none");
  }

  // --------------------------------------------------------------------
  // 🔤 Expressão regular para nomes com acentos (3 a 30 caracteres)
  // --------------------------------------------------------------------
  const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]{3,30}$/;

  // --------------------------------------------------------------------
  // 📦 ViaCEP – preenche automaticamente endereço ao sair do campo CEP
  // --------------------------------------------------------------------
  $("#cep").on("focusout", function () {
    const raw = $(this).val().replace(/\D/g, "");
    if (raw.length === 8) {
      $.getJSON(`https://viacep.com.br/ws/${raw}/json/`, function (data) {
        if (!data.erro) {
          $("#rua").val(data.logradouro || "");
          $("#bairro").val(data.bairro || "");
          $("#cidade").val(data.localidade || "");
          $("#uf").val(data.uf || "");
        }
      });
    }
  });

  // --------------------------------------------------------------------
  // 🧱 Máscaras dos campos CPF, CEP e Telefone
  // --------------------------------------------------------------------
  $("#idCpf").on("input", function () {
    let mascara = $(this).val().replace(/\D/g, "");
    mascara = mascara.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, "$1.$2.$3-$4");
    $(this).val(mascara);
  });

  $("#cep").on("input", function () {
    let mascara = $(this).val().replace(/\D/g, "");
    mascara = mascara.replace(/(\d{5})(\d{3})/, "$1-$2");
    $(this).val(mascara);
  });

  $("#telefone").on("input", function () {
    let mascara = $(this).val().replace(/\D/g, "");
    mascara = mascara.replace(/^(\d{2})(\d{5})(\d{4})$/, "($1) $2-$3");
    $(this).val(mascara);
  });

  // --------------------------------------------------------------------
  // 👁️ Alternância de exibição de senha (olhinho)
  // --------------------------------------------------------------------
  function toggleEye(btnId, inputId) {
    const $btn = $(`#${btnId}`);
    const $input = $(`#${inputId}`);
    if (!$btn.length || !$input.length) return;

    $btn.on("click", function () {
      if ($input.attr("type") === "password") {
        $input.attr("type", "text");
        $btn.removeClass("bi-eye-fill").addClass("bi-eye-slash-fill");
      } else {
        $input.attr("type", "password");
        $btn.removeClass("bi-eye-slash-fill").addClass("bi-eye-fill");
      }
      $input.focus();
    });
  }

  toggleEye("btn-exibirSenha", "senha");
  toggleEye("btn-aparecerSenha", "confirmaSenha");

  // --------------------------------------------------------------------
  // ✅ Validação geral ao enviar o formulário
  // --------------------------------------------------------------------
  $form.on("submit", function (e) {
    e.preventDefault();
    limparErrosCampos();
    let temErro = false;

    const campos = {
      Nome: $("#idNome").val().trim(),
      Sobrenome: $("#idSobrenome").val().trim(),
      NomeMaterno: $("#idnomeMaterno").val().trim(),
      Cpf: $("#idCpf").val().trim(),
      Cep: $("#cep").val().trim(),
      Endereco: $("#rua").val().trim(),
      Bairro: $("#bairro").val().trim(),
      Cidade: $("#cidade").val().trim(),
      Estado: $("#uf").val().trim(),
      Telefone: $("#telefone").val().trim(),
      Email: $("#email").val().trim(),
      Senha: $("#senha").val(),
      ConfirmaSenha: $("#confirmaSenha").val()
    };

    // Validação de Nome, Sobrenome e Nome Materno
    $.each(["Nome", "Sobrenome", "NomeMaterno"], function (_, campo) {
      if (campos[campo] === "") {
        mostrarErroCampo(campo, `Preencha o campo ${campo.toLowerCase()}.`);
        temErro = true;
      } else if (!regexNome.test(campos[campo])) {
        mostrarErroCampo(campo, `${campo} deve ter entre 3 e 30 caracteres e conter apenas letras.`);
        temErro = true;
      }
    });

    // CPF
    if (campos.Cpf === "") { mostrarErroCampo("Cpf", "Preencha o campo CPF."); temErro = true; }
    else if (!/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(campos.Cpf)) {
      mostrarErroCampo("Cpf", "O CPF deve estar no formato 123.456.789-00.");
      temErro = true;
    }

    // CEP
    if (campos.Cep === "") { mostrarErroCampo("Cep", "Preencha o campo CEP."); temErro = true; }
    else if (!/^\d{5}-\d{3}$/.test(campos.Cep)) {
      mostrarErroCampo("Cep", "O CEP deve estar no formato 12345-678.");
      temErro = true;
    }

    // Endereço, Bairro, Cidade, Estado
    $.each(["Endereco", "Bairro", "Cidade", "Estado"], function (_, campo) {
      if (campos[campo] === "") {
        mostrarErroCampo(campo, `Preencha o campo ${campo.toLowerCase()}.`);
        temErro = true;
      }
    });

    // Telefone
    if (campos.Telefone === "") { mostrarErroCampo("Telefone", "Preencha o campo telefone."); temErro = true; }
    else if (!/^\(\d{2}\)\s\d{5}-\d{4}$/.test(campos.Telefone)) {
      mostrarErroCampo("Telefone", "O telefone deve estar no formato (21) 99999-5555.");
      temErro = true;
    }

    // E-mail
    if (campos.Email === "") { mostrarErroCampo("Email", "Preencha o campo e-mail."); temErro = true; }
    else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(campos.Email)) {
      mostrarErroCampo("Email", "Informe um e-mail válido."); temErro = true;
    }

    // Senhas
    if (campos.Senha === "") { mostrarErroCampo("Senha", "Preencha o campo senha."); temErro = true; }
    else if (campos.Senha.length < 8) {
      mostrarErroCampo("Senha", "A senha deve ter pelo menos 8 caracteres.");
      temErro = true;
    }
    if (campos.ConfirmaSenha === "") { mostrarErroCampo("ConfirmaSenha", "Confirme sua senha."); temErro = true; }
    else if (campos.Senha !== campos.ConfirmaSenha) {
      mostrarErroCampo("ConfirmaSenha", "As senhas devem ser iguais.");
      temErro = true;
    }

    // Caso haja erro, mostra painel e rola até o primeiro erro
    if (temErro) {
      $mensagensErro.removeClass("d-none")
        .text("Existem erros no formulário. Corrija e tente novamente.");
      const $primeiroErro = $(".erro-msg").filter(function () { return $(this).text().trim() !== ""; }).first();
      if ($primeiroErro.length) {
        $("html, body").animate({ scrollTop: $primeiroErro.offset().top - 100 }, 600);
      }
      return;
    }

    // Se não houver erros, submete o formulário normalmente
    $mensagensErro.addClass("d-none");
    $form.off("submit").submit();
  });
});


