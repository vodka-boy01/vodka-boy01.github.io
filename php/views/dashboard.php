<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Amministratore</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <link rel="stylesheet" href="/assets/css/dashboard.css">
  <link rel="stylesheet" href="/assets/css/colors-purple.css">
  <script src="assets/js/load.js"></script>
</head>
<body class="min-h-screen p-6">
    <div class="loading-screen">
      <div class="spinner"></div>
  </div>
  <div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-8 text-center">Admin Dashboard</h1>
    <div class="flex gap-6">
      <!-- Sezione Nuovo Progetto -->
      <div class="w-3/5">
        <div class="box p-6">
          <h2 class="text-2xl font-bold mb-6">Nuovo Progetto</h2>
          <form id="form">
            <div class="mb-4">
              <label for="title" class="block mb-2">Titolo</label>
              <input type="text" id="title" class="input" placeholder="Titolo progetto" required>
            </div>
            <div class="mb-4">
              <label for="desc" class="block mb-2">Descrizione</label>
              <input type="text" id="desc" class="input" placeholder="Breve descrizione" maxlength="150" required>
            </div>
            <div class="mb-4">
              <label for="full" class="block mb-2">Descrizione Completa</label>
              <textarea id="full" rows="5" class="input resize-none" placeholder="Descrizione dettagliata" required></textarea>
            </div>
            <div class="mb-6">
              <label class="block mb-2">Immagini <span id="imgCount" class="text-sm text-gray-400">(0/10)</span></label>
              <div class="w-full mb-4">
                <label for="imgs" class="flex items-center justify-center h-32 border-2 border-dashed border-gray-500 rounded cursor-pointer bg-gray-800 hover:bg-gray-700">
                  <div class="text-center">
                    <i class="ri-upload-2-line ri-xl"></i>
                    <p class="mt-1 text-sm">Carica immagini (max 10)</p>
                  </div>
                  <input id="imgs" type="file" class="hidden" accept="image/*" multiple>
                </label>
              </div>
              <div id="preview-grid" class="grid grid-cols-5 gap-4"></div>
            </div>
            <div class="mb-4">
              <label class="block mb-2">Stato</label>
              <label class="switch">
                <input type="checkbox" id="status" checked>
                <span class="slider"></span>
              </label>
              <span class="ml-2" id="status-text">Attivo</span>
            </div>
            <div class="flex gap-4">
              <button type="submit" class="btn btn-green px-6 py-2 rounded-button">Salva</button>
              <button type="reset" class="btn btn-red px-6 py-2 rounded-button">Annulla</button>
            </div>
          </form>
        </div>
      </div>
      <!-- Sezione Utenti -->
      <div class="w-2/5">
        <div class="box p-6">
          <h2 class="text-2xl font-bold mb-6">Utenti</h2>
          <div class="table-wrap">
            <table class="w-full">
              <thead>
                <tr class="border-b border-[var(--color-hover)]">
                  <th class="p-4 text-left">Nome</th>
                  <th class="p-4 text-left">Cognome</th>
                  <th class="p-4 text-left">Username</th>
                  <th class="p-4 text-left">Email</th>
                  <th class="p-4 text-left">Ruolo</th>
                  <th class="p-4 text-left">Azioni</th>
                </tr>
              </thead>
              <tbody id="users">
                <tr class="row border-b border-[var(--color-hover)]">
                  <td class="py-3 px-4">Marco</td>
                  <td class="py-3 px-4">Rossi</td>
                  <td class="py-3 px-4">marco.rossi</td>
                  <td class="py-3 px-4">marco.rossi@example.com</td>
                  <td class="py-3 px-4">Admin</td>
                  <td class="py-3 px-4">
                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-primary">
                      <i class="ri-edit-line ri-lg"></i>
                    </button>
                  </td>
                </tr>
                <tr class="row border-b border-[var(--color-hover)]">
                  <td class="py-3 px-4">Giulia</td>
                  <td class="py-3 px-4">Bianchi</td>
                  <td class="py-3 px-4">giulia.bianchi</td>
                  <td class="py-3 px-4">giulia.bianchi@example.com</td>
                  <td class="py-3 px-4">Editor</td>
                  <td class="py-3 px-4">
                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-primary">
                      <i class="ri-edit-line ri-lg"></i>
                    </button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Toast Notifications -->
  <div id="successToast" class="toast success">
    <div class="flex items-center">
      <div class="w-6 h-6 mr-2 flex items-center justify-center"><i class="ri-check-line ri-lg"></i></div>
      <span id="successMessage">Operazione completata con successo!</span>
    </div>
  </div>
  <div id="errorToast" class="toast error">
    <div class="flex items-center">
      <div class="w-6 h-6 mr-2 flex items-center justify-center"><i class="ri-error-warning-line ri-lg"></i></div>
      <span id="errorMessage">Si è verificato un errore!</span>
    </div>
  </div>

  <script src="/assets/js/dashboard.js"></script>
</body>
</html>
