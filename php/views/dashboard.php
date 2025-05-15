<style>
/* ========== Dashboard Amministratore ========== */
.dashboard-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 1.5rem;
}
.dashboard-header {
    text-align: center;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 2rem;
}
.dashboard-box {
    background-color: var(--bg-color);
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    padding: 1.5rem;
    margin-bottom: 1.5rem;
}
.dashboard-form .form-group {
    margin-bottom: 1rem;
}
.dashboard-form .form-group label {
    display: block;
    margin-bottom: 0.5rem;
}
.dashboard-form .form-group input,
.dashboard-form .form-group textarea {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--color-hover);
    border-radius: 4px;
    background-color: #374151;
    color: var(--main-color);
    transition: border-color 0.3s ease;
}
.dashboard-form .form-group input:focus,
.dashboard-form .form-group textarea:focus {
    border-color: var(--color-hover);
    outline: none;
}
.dashboard-buttons {
    display: flex;
    gap: 1rem;
}
.dashboard-buttons .btn {
    flex: 1;
    padding: 0.75rem;
    font-size: 1rem;
}
.user-table {
    width: 100%;
    border-collapse: collapse;
}
.user-table th,
.user-table td {
    padding: 0.75rem;
    border-bottom: 1px solid var(--color-hover);
    text-align: left;
}
.user-table tr:nth-child(odd) {
    background-color: rgba(55,65,81,0.5);
}
.user-table tr:hover {
    background-color: rgba(75,85,99,0.5);
}
/* Anteprima immagine */
#preview {
    display: none;
    width: 8rem;
    height: 8rem;
    overflow: hidden;
    border-radius: 4px;
    background: #374151;
}
#preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
/* Switch */
.switch {
    position: relative;
    display: inline-block;
    width: 50px;
    height: 24px;
}
.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}
.switch .slider {
    position: absolute;
    inset: 0;
    background: #ccc;
    border-radius: 24px;
    transition: .4s;
}
.switch .slider:before {
    content: "";
    position: absolute;
    width: 18px;
    height: 18px;
    left: 3px;
    bottom: 3px;
    background: #fff;
    border-radius: 50%;
    transition: .4s;
}
.switch input:checked + .slider {
    background: var(--color-hover);
}
.switch input:checked + .slider:before {
    transform: translateX(26px);
}
/* Toast */
.toast {
    position: fixed;
    top: 1rem;
    right: 1rem;
    padding: 1rem;
    border-radius: 4px;
    color: #fff;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.3s ease;
    z-index: 999;
}
.toast.show {
    opacity: 1;
    pointer-events: auto;
}
.toast.success { background-color: var(--color-hover); }
.toast.error   { background-color: var(--color-hover-secondary); }
/* Scrollbar */
.dashboard-box::-webkit-scrollbar {
    width: 8px;
}
.dashboard-box::-webkit-scrollbar-track {
    background: var(--bg-color);
}
.dashboard-box::-webkit-scrollbar-thumb {
    background: var(--color-hover);
    border-radius: 4px;
}
</style>

<div class="dashboard-container">
  <h1 class="dashboard-header">Dashboard Amministratore</h1>
  <div class="flex gap-6">
    <!-- Nuovo Progetto -->
    <div class="w-3/5">
      <div class="dashboard-box">
        <h2 class="text-xl font-bold mb-4">Nuovo Progetto</h2>
        <form id="dashboard-form" class="dashboard-form">
          <div class="form-group">
            <label for="title">Titolo</label>
            <input type="text" id="title" placeholder="Titolo progetto" required />
          </div>
          <div class="form-group">
            <label for="desc">Descrizione</label>
            <input type="text" id="desc" placeholder="Breve descrizione" maxlength="150" required />
          </div>
          <div class="form-group">
            <label for="full">Descrizione Completa</label>
            <textarea id="full" rows="4" placeholder="Descrizione dettagliata" required></textarea>
          </div>
          <div class="form-group">
            <label>Immagine</label>
            <div class="flex gap-4 items-center">
              <label for="img" class="btn primary">
                <i class="fas fa-upload"></i> Carica immagine
              </label>
              <input type="file" id="img" accept="image/*" hidden />
              <div id="preview"><img id="preview-img" src="#" alt="Preview" /></div>
            </div>
          </div>
          <div class="form-group flex items-center">
            <label class="switch mr-2">
              <input type="checkbox" id="status" checked />
              <span class="slider"></span>
            </label>
            <span id="status-text">Attivo</span>
          </div>
          <div class="dashboard-buttons">
            <input type="submit" class="btn primary" value="Salva" />
            <input type="reset" class="btn secondary" value="Annulla" />
          </div>
        </form>
      </div>
    </div>
    <!-- Utenti -->
    <div class="w-2/5">
      <div class="dashboard-box">
        <h2 class="text-xl font-bold mb-4">Utenti</h2>
        <div class="table-wrap">
          <table class="user-table">
            <thead>
              <tr>
                <th>Nome</th><th>Email</th><th>Ruolo</th><th>Azioni</th>
              </tr>
            </thead>
            <tbody id="users">
              <!-- righe generate via JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notifications -->
  <div id="successToast" class="toast success">Operazione completata con successo!</div>
  <div id="errorToast" class="toast error">Si è verificato un errore!</div>
</div>

<script>
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
    const file = e.target.files[0];
    if (file) {
      previewImg.src = URL.createObjectURL(file);
      preview.style.display = 'block';
    }
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
</script>