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
const statoColore = localStorage.getItem("statoColore");
const colorChange = document.getElementById('circle-icon');

colorChange.addEventListener('click', function(){
  
  /*
    console.log(localStorage)
    if(statoColore === 0 ){
    localStorage.setItem("statoColore", "1");
    console.log(statoColore)
    document.documentElement.style.setProperty('--main-color', 'red');
    document.documentElement.style.setProperty('--animation-state', 'running');

    setTimeout(function() {
    document.documentElement.style.setProperty('--animation-state', 'paused');
    }, 1300); 
  }
  else{
    localStorage.setItem("statoColore", "0");
    document.documentElement.style.setProperty('--main-color', 'green');

  }
  */
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