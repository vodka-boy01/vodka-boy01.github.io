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
const colorChange = document.getElementById('circle-icon');

window.onload = function(){/*quando la pagina si ricarica esegue la funzione di verifica del colore*/
if (!value) { // se il valore non esiste, lo inizializziamo a 0
  value = 0;
}
value = Number(value);// converte il valore in un numero

value = 1 - value; // inverte il valore 
console.log(localStorage);
statoColore();
}

let value = localStorage.getItem("statoColore");
colorChange.addEventListener('click', function(){

  if (!value) { // se il valore non esiste, lo inizializziamo a 0
    value = 0;
  }
  value = Number(value);// converte il valore in un numero

  value = 1 - value; // inverte il valore 

  localStorage.setItem("statoColore", value);// salva il nuovo valore in localStorage

  console.log(`Il nuovo valore è ${value}`); // stampa il nuovo valore nella console

  document.documentElement.style.setProperty('--animation-state', 'running');
  
  setTimeout(function() {
  document.documentElement.style.setProperty('--animation-state', 'paused');
  
  }, 1300); 
  statoColore();
});
function statoColore(){
if(value === 0){
  document.documentElement.style.setProperty('--main-color', '250, 250, 250');
  document.documentElement.style.setProperty('--bg-color', '37, 39, 40');
  document.documentElement.style.setProperty('--color-main', '22, 24, 25');
  document.documentElement.style.setProperty('--color-bg-main', 'gray');
}
else{
  document.documentElement.style.setProperty('--main-color', 'gray');
  document.documentElement.style.setProperty('--bg-color', '#715fde');
  document.documentElement.style.setProperty('--color-main', 'black');
  document.documentElement.style.setProperty('--color-bg-main', 'white');
}
}
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