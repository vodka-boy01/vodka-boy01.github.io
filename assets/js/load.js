// impostando subito il tema pagina sul tag html e non body si evia il flickering per il caricamento della pagina
/*check local storage tema dark*/
window.onload = function() {
    const tema = localStorage.getItem("tema");
    if (tema === "true") {
        console.log("Tema salvato: dark");
        document.documentElement.classList.add("dark-theme");
    }
}();

/*content load check*/
window.addEventListener('load', function() {
    //fade out pagina login
    const loadingScreen = document.querySelector('.loading-screen');
    loadingScreen.classList.add('fade-out');
    
    //interruzione spinner
    const spinnerStop = document.querySelector('.spinner');
    spinnerStop.classList.add('stop');
});