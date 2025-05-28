document.addEventListener('DOMContentLoaded', () => {
  const form       = document.getElementById('dashboard-form');
  const imgInput   = document.getElementById('img');
  const preview    = document.getElementById('preview');
  const previewImg = document.getElementById('preview-img');
  const status     = document.getElementById('status');
  const statusText = document.getElementById('status-text');
  const successT   = document.getElementById('successToast');
  const errorT     = document.getElementById('errorToast');

    imgInput.addEventListener('change', e => {
    const files = Array.from(e.target.files);
    preview.innerHTML = ''; // preview empty
    files.forEach(file => {
        const img = document.createElement('img');
        img.src = URL.createObjectURL(file);
        img.alt = 'Preview';
        preview.appendChild(img);
    });
    preview.style.display = files.length ? 'flex' : 'none';
    });


  status.addEventListener('change', () => {
    statusText.textContent = status.checked ? 'Attivo' : 'Inattivo';
  });

  form.addEventListener('reset', () => {
    preview.style.display = 'none';
    status.checked = true;
    statusText.textContent = 'Attivo';
  });

  form.addEventListener('submit', e => {
    e.preventDefault();
    // TODO: logica invio dati...
    showToast(successT);
  });

  function showToast(el) {
    el.classList.add('show');
    setTimeout(() => el.classList.remove('show'), 3000);
  }
   
});