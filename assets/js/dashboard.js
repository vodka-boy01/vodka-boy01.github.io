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

  // Gestione selezione delle immagini
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
            imgCount.textContent = `(${uploadedImages.length}/20)`;
          };

          wrapper.append(imgEl, btn);
          previewGrid.appendChild(wrapper);
          uploadedImages.push(file);
          imgCount.textContent = `(${uploadedImages.length}/20)`;
        };
        reader.readAsDataURL(file);
      }
    });
    // reset input per permettere nuove selezioni
    imgs.value = '';
  });

  // Gestione reset del form
  form.addEventListener('reset', () => {
    previewGrid.innerHTML = '';
    uploadedImages = [];
    imgCount.textContent = '(0/20)';
    status.checked = true;
    statusText.textContent = 'Attivo';
  });

  // Cambio testo stato
  status.addEventListener('change', () => {
    statusText.textContent = status.checked ? 'Progetto' : 'Evento';
  });

  // Gestione submit 
  form.addEventListener('submit', e => {
    e.preventDefault();
    const targetUrl = form.getAttribute('action') || window.location.href;
    const fd = new FormData();
    
    // aggiungi campi non-file
    form.querySelectorAll("input:not([type=file]), textarea, select").forEach(el => {
      if (!el.name) return;
      if (el.type === 'checkbox') {
        if (el.checked) fd.append(el.name, el.value || 'on');
      } else {
        fd.append(el.name, el.value);
      }
    });

    // aggiungi file accumulati
    uploadedImages.forEach(file => fd.append('imgs[]', file));

    fetch(targetUrl, {
      method: form.method,
      body: fd
    })
    .then(response => response.text())
    .then(html => {
      document.open();
      document.write(html);
      document.close();
    })
    .catch(() => showToast('Errore invio form', 'error'));
  });
});
