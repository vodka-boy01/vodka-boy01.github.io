window.onload = function() {
  console.log("Verifico percorso");

  //lancia modulo ricerca solo in index.html
  if (window.location.pathname.endsWith("index.html")) {
    searchModule.init();
  }

  console.log("Verifico colore salvato in memoria");
  let tema = localStorage.getItem("tema");

  //default tema chiaro
  if (tema === null) {
    tema = "false";
    localStorage.setItem("tema", tema);
    console.log("Tema non presente, impostato su chiaro (false)");
  }

  //se true -> dark
  //se false -> light
  if (tema === "true") {
    console.log("Tema salvato: dark");
    document.body.classList.add("dark-theme");
  } else {
    console.log("Tema salvato: light");
    document.body.classList.remove("dark-theme");
  }

  aggiornaIconeTema(tema === "true");
};

//modulo per la gestione del campo di ricerca in alternativa a placeholder
const searchModule = {
  init: function() {
    const searchInput = document.getElementById('search-input');

    searchInput.addEventListener('focus', function() {
      if (this.value === 'CERCA') {
        this.value = '';
      }
    });

    searchInput.addEventListener('blur', function() {
      if (this.value === '') {
        this.value = 'CERCA';
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
    document.body.classList.add("dark-theme");
    console.log("Tema cambiato: dark");
  } else {
    tema = "false";
    document.body.classList.remove("dark-theme");
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
