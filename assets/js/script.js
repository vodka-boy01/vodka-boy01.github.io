window.onload = function() {

  //lancia modulo ricerca solo in index.html
  if (window.location.pathname.endsWith("index.html")) {
    searchModule.init();
  }

  const tema = localStorage.getItem("tema");

  //se true -> dark    viene gia verificato nello script in load.js
  //se false -> light
  //la verifica dell'esistenza di tema viene fatta in load.js
  if (tema === "false") {
    console.log("Tema salvato: light");
    document.documentElement.classList.remove("dark-theme");
  }

  aggiornaIconeTema(tema);
};

//modulo per la gestione del campo di ricerca alternativa a placeholder
const searchModule = {
  init: function() {
    const searchInput = document.getElementById('search-input');

    searchInput.addEventListener('focus', function() {
      if (this.value === 'Ricerca') {
        this.value = '';
      }
    });

    searchInput.addEventListener('blur', function() {
      if (this.value === '') {
        this.value = 'Ricerca';
      }
    });
  }
}

//funzione di cambio colore onclick
function colorChange() {
  let tema = localStorage.getItem("tema");

  //se attuale è chiaro → passo a scuro
  if (tema === "false") {
    tema = "true";
    document.documentElement.classList.add("dark-theme");
    console.log("Tema cambiato: dark");
  } else {
    tema = "false";
    document.documentElement.classList.remove("dark-theme");
    console.log("Tema cambiato: light");
  }

  localStorage.setItem("tema", tema);//aggiorna tema in localstorage
  aggiornaIconeTema(tema === "true");//cambia icona pagina
  console.log(localStorage);//output localstorage per dubug
}

//cambia le icone del toggle tema in base al tema corrente
function aggiornaIconeTema(tema) {
  const lightIcon = document.getElementById('light');
  const darkIcon = document.getElementById('dark');

  if (tema) {
    lightIcon.classList.remove('fa-sun');
    darkIcon.classList.add('fa-moon');
  } else {
    lightIcon.classList.add('fa-sun');
    darkIcon.classList.remove('fa-moon');
  }
}
