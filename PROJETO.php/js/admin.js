
  const fotoInput = document.getElementById('fotoInput');
  const fotoPerfil = document.getElementById('adminFoto');

  // Carregar imagem salva anteriormente
  document.addEventListener('DOMContentLoaded', () => {
    const imgSalva = localStorage.getItem('fotoAdmin');
    if (imgSalva) fotoPerfil.src = imgSalva;
  });

  // Atualizar imagem ao selecionar novo arquivo
  fotoInput.addEventListener('change', (e) => {
    const arquivo = e.target.files[0];
    if (arquivo) {
      const leitor = new FileReader();
      leitor.onload = () => {
        fotoPerfil.src = leitor.result;
        localStorage.setItem('fotoAdmin', leitor.result);
      };
      leitor.readAsDataURL(arquivo);
    }
  });
  