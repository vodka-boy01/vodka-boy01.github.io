const searchInput = document.querySelector('input[type="search"]');
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
