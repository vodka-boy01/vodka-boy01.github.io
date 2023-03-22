//testo che scompare nella digitazione 
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

/*cancella il campo di ricerca*/
function clearSearch(){
  document.getElementById("search-input").value = "CERCA";
}
/*cambio dinamico dei colori del sito: std su bianco, con save in localstorage*/

const lightIcon = document.getElementById('light');
const darkIcon = document.getElementById('dark');
const colorChange = document.getElementById('circle-icon');
const iconLightDark = document.getElementById('#light');
let value = localStorage.getItem("statoColore");


window.onload = function(){/*quando la pagina si ricarica esegue la funzione di verifica del colore*/
if (!value) { // se il valore non esiste, lo inizializziamo a 0
  value = 0;
}
value = Number(value);// converte il valore in un numero
localStorage.setItem("statoColore", value);
if(value === 0){
  document.body.classList.toggle("dark-theme");
  lightIcon.classList.add('fa-sun');
  darkIcon.classList.remove('fa-moon');
}
else{
  lightIcon.classList.remove('fa-sun');
  darkIcon.classList.add('fa-moon');
}
console.log(localStorage);
}

colorChange.addEventListener('click', function(){
  document.body.classList.toggle("dark-theme");
  statoColore();
});
function statoColore(){
if(value === 0){
  value = 1;
  localStorage.setItem("statoColore", value);// salva il nuovo valore in localStorage
  console.log(`Il nuovo valore è ${value}`); // stampa il nuovo valore nella console
  lightIcon.classList.remove('fa-sun');
  darkIcon.classList.add('fa-moon');
}
else{
  value = 0;
  localStorage.setItem("statoColore", value);
  console.log(`Il nuovo valore è ${value}`); // stampa il nuovo valore nella console
  lightIcon.classList.add('fa-sun');
  darkIcon.classList.remove('fa-moon');
}
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