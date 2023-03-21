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
/*cambio dinamico dei colori del sito: std su bianco///////////////*/
const colorChange = document.getElementById('circle-icon');
/*var colorValue = 0;if(colorValue === )*/
colorChange.addEventListener('click', function(){
  /*aggiungere tutti i colori per le i cambi dinamici, e aggiungere un bottone al lato sinistro del bottone login per la transizione di colore della pagina*/
  document.documentElement.style.setProperty('--main-color', 'red');
});


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