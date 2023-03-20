const searchInput = document.getElementById('search-input');
//solo tipi di input search
searchInput.addEventListener('focus', function() {
  if(this.value === 'CERCA') {
    this.value = '';
  }
});
//testo che scompare nella digitazione 
searchInput.addEventListener('blur', function() {
  if(this.value === '') {
    this.value = 'CERCA';
  }
});
/*cancella il campo di ricerca*/
function clearSearch(){
  document.getElementById("search-input").value = "CERCA";
}
/*cambio dinamico dei colori del sito: std su bianco///////////////*/
const colorChange = document.getElementById('login-icon');
/*var colorValue = 0;if(colorValue === )*/
colorChange.addEventListener('click', function(){
  /*aggiungere tutti i colori per le i cambi dinamici, e aggiungere un bottone al lato sinistro del bottone login per la transizione di colore della pagina*/
  document.documentElement.style.setProperty('--main--color', 'red');
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