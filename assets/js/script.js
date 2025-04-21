window.onload = function(){
  /*lancia searchmodule onload*/
  if(window.location.pathname.endsWith("index.html")){
    searchModule.init();
  }

  /*verifica se esiste statocolore e ripristina tema pagina onload*/
  const lightIcon = document.getElementById('light');
  const darkIcon = document.getElementById('dark');
  const colorChange = document.getElementById('circle-icon');
  const iconLightDark = document.getElementById('#light');
  let statoColore = localStorage.getItem("statoColore");

  if (!statoColore) {
    statoColore = 0;
    localStorage.setItem("statoColore", statoColore);
  }

  if(statoColore === 0){
    document.body.classList.toggle("dark-theme");
    lightIcon.classList.add('fa-sun');
    darkIcon.classList.remove('fa-moon');
  }
  else{
    lightIcon.classList.remove('fa-sun');
    darkIcon.classList.add('fa-moon');
  }
}
/*barra di ricerca*/
const searchModule = {
  init: function(){
    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('focus', function() {
      if(this.value === 'CERCA') {
        this.value = '';
      }
    });
    searchInput.addEventListener('blur', function() {
      if(this.value === '') {
        this.value = 'CERCA';
      }
    });
    /*quando c'è qualcosa scritto in input search rimane in focus*/
  }
}

/*cancella il campo di ricerca*/
function clearSearch(){
  document.getElementById("search-input").value = "CERCA";
}

/*cambia colore su click utente */
function colorChange(){
  const lightIcon = document.getElementById('light');
  const darkIcon = document.getElementById('dark');
  const colorChange = document.getElementById('circle-icon');
  const iconLightDark = document.getElementById('#light');
  let statoColore = localStorage.getItem("statoColore");
  statoColore = Number(statoColore);// converte il valore in un numero
  
  document.body.classList.toggle("dark-theme");
  if(statoColore === 0){
    statoColore = 1;
    localStorage.setItem("statoColore", statoColore);// salva il nuovo valore in localStorage
    console.log(`Il nuovo valore colore è ${statoColore}`); // stampa il nuovo valore nella console
    lightIcon.classList.remove('fa-sun');
    darkIcon.classList.add('fa-moon');
  }
  else{
    statoColore = 0;
    localStorage.setItem("statoColore", statoColore);
    console.log(`Il nuovo valore colore è ${statoColore}`); // stampa il nuovo valore nella console
    lightIcon.classList.add('fa-sun');
    darkIcon.classList.remove('fa-moon');
  }
  console.log(localStorage);
}

/*
  document.documentElement.style.setProperty('--animation-state', 'running');
  
  setTimeout(function() {
  document.documentElement.style.setProperty('--animation-state', 'paused');
  
  }, 1300); 
*/
/* 
  console.log(localStorage)
  if(statoColore === 0 ){
  localStorage.setItem("statoColore", 1);
  console.log(statoColore)
  document.documentElement.style.setProperty('--main-color', 'red');
  document.documentElement.style.setProperty('--animation-state', 'running');

  setTimeout(function() {
  document.documentElement.style.setProperty('--animation-state', 'paused');
  }, 1300); 
  }
  else{
  localStorage.setItem("statoColore", 0);
  document.documentElement.style.setProperty('--main-color', 'green');
  }
*/

/*
function clearSearch() {//
  document.getElementById("reset").onclick = function(){
    setTimeout(dalayDelete, 500);
  }
  function dalayDelete(){
    document.getElementById("search").value = "CERCA";
  }     
}
*/
/*
document.getElementById("reset").onclick = function(){
  setTimeout(clearSearch, 500);
}     //delay per cancellare il testo
*/ 