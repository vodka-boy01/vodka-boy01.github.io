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
const statoColore = localStorage.getItem("stato-colore");
const colorChange = document.getElementById('circle-icon');
colorChange.addEventListener('click', function(){
  console.log(statoColore)
  if(statoColore == 0){
    document.documentElement.style.setProperty('--main-color', 'red');
    document.documentElement.style.setProperty('--animation-state', 'running');
    
    setTimeout(function() {/*imposta il tempo di attesa per fermare l'animazione*/
    document.documentElement.style.setProperty('--animation-state', 'paused');
    }, 1300); 
    localStorage.setItem("stato-colore", "1");
  }
  else{
    localStorage.setItem("stato-colore", "0");
  }
  console.log(localStorage);
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