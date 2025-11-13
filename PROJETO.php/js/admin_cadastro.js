document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const mensagensErro = document.getElementById('mensagensErro');

  //API DE CEP 
  document.getElementById('cep').addEventListener('focusout', function () {
    const raw = this.value.replace(/\D/g, '-');
    if (raw.length === 9) {
      fetch('https://viacep.com.br/ws/' + raw + '/json/')
        .then(r => r.json())
        .then(data => {
          if (!data.erro) {
            document.getElementById('rua').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('uf').value = data.uf || '';
          }
        });
    };
  });

  // Máscaras de entrada
  document.getElementById('idCpf').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '') // Remove caracteres não numéricos
      .replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'); // Formato do CPF
  });

  document.getElementById('cep').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '') // Remove caracteres não numéricos
      .replace(/(\d{5})(\d{3})/, '$1-$2'); // Formato do CEP
  });

  document.getElementById('telefone').addEventListener('input', function (e) {
    e.target.value = e.target.value.replace(/\D/g, '') // Remove caracteres não numéricos
      .replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3'); // Formato de telefone
  });

  // exibição de senha
  function exibirSenha() {
    var inputSenha = document.getElementById('senha');
    var btnshowPass = document.getElementById('btn-exibirSenha');

    if (inputSenha.type === 'password') {
      inputSenha.setAttribute('type', 'text');
      btnshowPass.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    }
    else {
      inputSenha.setAttribute('type', 'password');
      btnshowPass.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    }
  };
  var btnshowPass = document.getElementById('btn-exibirSenha');
  btnshowPass.addEventListener('click', exibirSenha);

  // exibição do confirmar senha
  function apresentarSenha() {
    var inputSenha = document.getElementById('confirmaSenha');
    var btnApresentarSenha = document.getElementById('btn-aparecerSenha');

    if (inputSenha.type === 'password') {
      inputSenha.setAttribute('type', 'text');
      btnApresentarSenha.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
    }
    else {
      inputSenha.setAttribute('type', 'password');
      btnApresentarSenha.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
    }
  };
  var btnApresentarSenha = document.getElementById('btn-aparecerSenha');
  btnApresentarSenha.addEventListener('click', apresentarSenha);

  // Função para validar o formulário
  form.addEventListener('submit', function (event) {
    event.preventDefault();
    let errors = [];

    // Validação de nome (máximo 100 caracteres alfabéticos)
   /* const nome = document.getElementById('idNome').value;
    if (!/^[A-Za-z\s]{1,100}$/.test(nome)) {
      errors.push("O nome deve ter no máximo 100 caracteres alfabéticos.");
    }*/

    // Validação de sobrenome (máximo 100 caracteres alfabéticos)
    /*const sobrenome = document.getElementById('idSobrenome').value;
    if (!/^[A-Za-z\s]{1,100}$/.test(sobrenome)) {
      errors.push("O sobrenome deve ter no máximo 100 caracteres alfabéticos.");
    }*/

    //Validação de nome Materno (máximo 100 caracteres alfabéticos)
    //const nomeMaterno = document.getElementById('idnomeMaterno').value;
    //if (!/^[A-Za-z\s]{1,100}$/.test(nomeMaterno)) {
      //errors.push("O nome materno deve ter no máximo 100 caracteres alfabéticos.");
    //}


    // Validação de senha (mínimo 8 caracteres)
    const senha = document.getElementById('senha').value;
    if (senha.length < 8) {
      errors.push("A senha deve ter pelo menos 8 caracteres.");
    }

    // Validação de senha e confirmação de senha
    const confirmaSenha = document.getElementById('confirmaSenha').value;
    if (senha !== confirmaSenha) {
      errors.push("A senha e a confirmação de senha devem ser iguais.");
    }

    // Validação de CPF (formato: 123.456.789-00)
    const cpf = document.getElementById('idCpf').value;
    if (!/^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(cpf)) {
      errors.push("O CPF deve estar no formato 123.456.789-00.");
    }

    // Validação de CEP (formato: 12345-678)
    const cep = document.getElementById('cep').value;
    if (!/^\d{5}-\d{3}$/.test(cep)) {
      errors.push("O CEP deve estar no formato 12345-678.");
    }
    //API CEP IRÁ VIR PARA CÁ APÓS A VALIDAÇÃO ---->

    // Validação de telefone (formato: (21) 99999-5555)
    const telefone = document.getElementById('telefone').value;
    if (!/^\(\d{2}\)\s\d{5}-\d{4}$/.test(telefone)) {
      errors.push("O telefone deve estar no formato (21) 99999-5555.");
    }

    // Exibição de erros
    if (errors.length > 0) {
      mensagensErro.classList.remove('d-none');
      mensagensErro.innerHTML = errors.join('<br>');
    } else {
      mensagensErro.classList.add('d-none');

      form.submit(); // Submete o formulário se não houver erros
    }
  });
});