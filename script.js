const searchInput = document.getElementById('search-input');
//solo tipi di input search
searchInput.addEventListener('focus', function() {
  if(this.value === 'CERCA') {
    this.value = '';
  }
});
//testo che scompare nella digitazione v
searchInput.addEventListener('blur', function() {
  if(this.value === '') {
    this.value = 'CERCA';
  }
});
function clearSearch(){
  document.getElementById("search-input").value = "CERCA";
}
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