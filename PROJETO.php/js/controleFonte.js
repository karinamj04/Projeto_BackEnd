let currentFontSize = 18; // tamanho inicial em pixels
let currentFontSize_title = 30; // tamanho inicial em pixels para os titulos

function adjustFontSize(change) {
    currentFontSize += change;
    currentFontSize_title += change;

    // Limite mínimo e máximo
    if (currentFontSize < 10) currentFontSize = 10;
    if (currentFontSize > 26) currentFontSize = 26;
    // Limite minimo e maximo titulo
    if (currentFontSize_title < 20) currentFontSize_title = 20;
    if (currentFontSize_title > 40) currentFontSize_title = 40;

    document.body.style.fontSize = currentFontSize + "px";
    document.querySelectorAll("a").forEach((el) => {
      el.style.fontSize = currentFontSize + "px";
    });
    document.querySelectorAll("button").forEach((el) => {
      el.style.fontSize = currentFontSize + "px";
    });
    document.querySelectorAll("p").forEach((el) => {
      el.style.fontSize = currentFontSize + "px";
    });
    document.querySelectorAll("input").forEach((el) => {
      el.style.fontSize = currentFontSize + "px";
    });


    document.querySelectorAll("h1").forEach((el) => {
      el.style.fontSize = currentFontSize_title + "px";
    });
    document.querySelectorAll("h2").forEach((el) => {
      el.style.fontSize = currentFontSize_title + "px";
    });
    document.querySelectorAll("h3").forEach((el) => {
      el.style.fontSize = currentFontSize_title + "px";
    });
    document.querySelectorAll("h4").forEach((el) => {
      el.style.fontSize = currentFontSize_title + "px";
    });
    document.querySelectorAll("h5").forEach((el) => {
      el.style.fontSize = currentFontSize_title + "px";
    });
  }
