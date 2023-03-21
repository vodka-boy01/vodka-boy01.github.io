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
colorChange.addEventListener('click', function(){
  let value = localStorage.getItem("statoColore");

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
  if(value === 0){
    document.documentElement.style.setProperty('--main-color', 'white');
    document.documentElement.style.setProperty('--bg-color', '51, 153, 101');
    document.documentElement.style.setProperty('--color-main', '52, 53, 65');
  }
  else{
    document.documentElement.style.setProperty('--main-color', 'black');
    document.documentElement.style.setProperty('--bg-color', '51, 153, 101');
    document.documentElement.style.setProperty('--color-main', '52, 53, 65');
  }
});

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