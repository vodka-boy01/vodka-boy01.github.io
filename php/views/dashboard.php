<head>
  <link rel="stylesheet" href="assets\css\style_adminDashboard.css">
</head>
<section class="dashboard-container">
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
              <input type="file" id="img" accept="image/*" hidden multiple/>
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
                <th>Nome</th>
                <th>Email</th>
                <th>Ruolo</th>
                <th>Azioni</th>
              </tr>
            </thead>
            <tbody id="users">
              <!-- righe generate via JS -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

  <!-- Toast Notifications -->
  <div id="successToast" class="toast success">Operazione completata con successo!</div>
  <div id="errorToast" class="toast error">Si è verificato un errore!</div>
  <script src="../assets/js/dashboard.js"></script>
</div>
