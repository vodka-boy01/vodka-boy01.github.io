document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('project-form'); // Rinominato per chiarezza
  const imgs = document.getElementById('imgs');
  const previewGrid = document.getElementById('preview-grid');
  const imgCount = document.getElementById('imgCount');
  const status = document.getElementById('status');
  const statusText = document.getElementById('status-text');
  let uploadedImages = [];

  // Funzione per mostrare i toast
  function showToast(message, type) {
    const toast = document.getElementById(type + 'Toast');
    document.getElementById(type + 'Message').textContent = message;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
  }

  // Controlla se ci sono messaggi PHP da mostrare e li visualizza
  const phpSuccessToast = document.getElementById('phpSuccessToast');
  if (phpSuccessToast && phpSuccessToast.classList.contains('show')) {
    setTimeout(() => phpSuccessToast.classList.remove('show'), 3000);
  }

  const phpErrorToast = document.getElementById('phpErrorToast');
  if (phpErrorToast && phpErrorToast.classList.contains('show')) {
    setTimeout(() => phpErrorToast.classList.remove('show'), 3000);
  }


  imgs.addEventListener('change', e => {
    const files = Array.from(e.target.files);
    const slots = 20 - uploadedImages.length;
    if (files.length > slots) {
      return showToast('Puoi caricare massimo 20 immagini', 'error');
    }
    files.forEach(file => {
      if (uploadedImages.length < 20) {
        const reader = new FileReader();
        reader.onload = evt => {
          const wrapper = document.createElement('div');
          wrapper.className = 'relative w-full aspect-square rounded bg-gray-800';

          const imgEl = document.createElement('img');
          imgEl.src = evt.target.result;
          imgEl.className = 'w-full h-full object-cover rounded';

          const btn = document.createElement('button');
          btn.className = 'absolute top-2 right-2 w-8 h-8 bg-red-500 rounded-full text-white flex items-center justify-center hover:bg-red-600';
          btn.innerHTML = '<i class="ri-close-line"></i>';
          btn.type = 'button'; // per evitare l'invio del form

          btn.onclick = () => {
            wrapper.remove();
            uploadedImages = uploadedImages.filter(f => f !== file);
            imgCount.textContent = `(${uploadedImages.length}/10)`;
          };

          wrapper.append(imgEl, btn);
          previewGrid.appendChild(wrapper);
          uploadedImages.push(file);
          imgCount.textContent = `(${uploadedImages.length}/10)`;
        };
        reader.readAsDataURL(file);
      }
    });
  });

  form.addEventListener('reset', () => {
    previewGrid.innerHTML = '';
    uploadedImages = [];
    imgCount.textContent = '(0/10)';
    status.checked = true;
    statusText.textContent = 'Attivo';
  });

  status.addEventListener('change', () => {
    statusText.textContent = status.checked ? 'Progetto' : 'Evento';
  });
  
});