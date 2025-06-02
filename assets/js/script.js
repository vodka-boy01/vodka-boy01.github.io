window.onload = function() {
  
  //lancia modulo ricerca solo in index.html
  if(window.location.pathname.endsWith("index.php")) {
    searchModule.init();
  }

  let tema = localStorage.getItem("tema");

  //default tema chiaro
  if(tema === null) {
    tema = "false";
    localStorage.setItem("tema", tema);
    console.log("Tema non presente, impostato su chiaro (false)");
  }

  //se true -> dark    viene gia verificato nello script in index.html
  //se false -> light
  if(tema === "false") {
    console.log("Tema salvato: light");
    document.documentElement.classList.remove("dark-theme");
  }

  aggiornaIconeTema(tema === "true");
  
  //TODO: da modificare
  //STATIC SLIDER SECTION
  const projectImageContainers = document.querySelectorAll('.project-card');

  projectImageContainers.forEach(projectCard => {
      const mainImage = projectCard.querySelector('.main-project-image');
      const thumbnails = projectCard.querySelectorAll('.thumbnail-image');

      thumbnails.forEach(thumbnail => {
          thumbnail.addEventListener('click', function() {
            thumbnails.forEach(t => t.classList.remove('active-thumbnail'));

            this.classList.add('active-thumbnail');

            mainImage.src = this.src;
          });
      });
  });

  //DINAMIC SLIDER SECTION
  const sliderContainer = document.querySelector('.slider-container');
  const prevButton = document.querySelector('.prev-button');
  const nextButton = document.querySelector('.next-button');
  const slides = document.querySelectorAll('.slide');
  const slideWidth = slides[0].offsetWidth + 20; 
  let currentSlide = 0;
  let autoScrollInterval;

  const scrollToSlide = (index) => {
   if (index < 0) {
     currentSlide = slides.length - 1; 
      }else if(index >= slides.length) {
        currentSlide = 0; 

      }else{
        currentSlide = index;

      }
      sliderContainer.scrollTo({
        left: currentSlide * slideWidth,
        behavior: 'smooth'
      });
  };

  prevButton.addEventListener('click', () => {
    scrollToSlide(currentSlide - 1);
  });

  nextButton.addEventListener('click', () => {
    scrollToSlide(currentSlide + 1);
  });

  const startAutoScroll = () => {
    autoScrollInterval = setInterval(() => {
    scrollToSlide(currentSlide + 1);
    }, 3000); 
  };

  const stopAutoScroll = () => {
    clearInterval(autoScrollInterval);
  };

  startAutoScroll();

  sliderContainer.style.overflowX = 'hidden'; 
  sliderContainer.style.scrollSnapType = 'none';

  //entrata mouse 
  prevButton.addEventListener('mouseenter', stopAutoScroll);
  nextButton.addEventListener('mouseenter', stopAutoScroll);
  prevButton.addEventListener('mouseleave', startAutoScroll);
  nextButton.addEventListener('mouseleave', startAutoScroll);

}

//modulo per la gestione del campo di ricerca in alternativa a placeholder
const searchModule = {
  init: function() {
    const searchInput = document.getElementById('search-input');
    const clearButton = document.getElementById('reset-button');

    searchInput.addEventListener('focus', function() {
      if (this.value === 'Ricerca') {
        this.value = '';
      }
    });

    searchInput.addEventListener('blur', function() {
      if (this.value === '') {
        this.value = 'Ricerca';
      }
    });

    clearButton.addEventListener('click', function(){
      searchInput = '';
    });
  }
}

//cancella la ricerca
function clearSearch(){
  const searchInput = document.getElementById('search-input');
  searchInput == '';
}

//funzione di cambio colore onclick
function colorChange() {
  let tema = localStorage.getItem("tema");

  //se attuale è chiaro → passo a scuro
  if (tema === "false") {
    tema = "true";
    document.documentElement.classList.add("dark-theme");
    console.log("Tema cambiato: dark");
  } else {
    tema = "false";
    document.documentElement.classList.remove("dark-theme");
    console.log("Tema cambiato: light");
  }

  localStorage.setItem("tema", tema);//aggiorna tema in localstorage
  aggiornaIconeTema(tema === "true");//cambia icona pagina
  console.log(localStorage);//output localstorage per dubug
}

//cambia le icone del toggle tema in base al tema corrente
function aggiornaIconeTema(tema) {
  const lightIcon = document.getElementById('light');
  const darkIcon = document.getElementById('dark');

  if (tema) {
    lightIcon.classList.remove('fa-sun');
    darkIcon.classList.add('fa-moon');
  } else {
    lightIcon.classList.add('fa-sun');
    darkIcon.classList.remove('fa-moon');
  }
}
