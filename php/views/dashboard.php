<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Dashboard Amministratore</title>
  <script src="https://cdn.tailwindcss.com/3.4.16"></script>
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet"/>
  <link rel="stylesheet" href="/assets/css/dashboard.css" />
  <link rel="stylesheet" href="/assets/css/colors-purple.css" />
  <script src="/assets/js/load.js"></script>
</head>
<body class="min-h-screen p-6">
  <?php
  session_start();

  require_once __DIR__ . '/../query/database.php';
  require_once __DIR__ . '/../query/user.php';
  require_once __DIR__ . '/../query/project.php';

  $conn = (new database())->connect();
  $userOperations = new user($conn);
  $projectOperations = new project($conn); 

  $error_message = '';
  $success_message = '';

  // gestione dell'aggiunta di un nuovo progetto
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_project') {
    $titolo = $_POST['title'] ?? '';
    $descrizione_breve = $_POST['desc'] ?? '';
    $descrizione_completa = $_POST['full'] ?? '';
    $stato = isset($_POST['status']) ? 1 : 0;
    $uploaded_image_details = [];
    //PERCORSO RELATIVO
    $server_path = __DIR__ . "/../../assets/uploads/" . basename($image_name);

    // gestione delle immagini caricate
    if(isset($_FILES['imgs']) && !empty($_FILES['imgs']['name'][0])) {

      if(!is_dir($target_dir)) {
        if(!mkdir($target_dir, 0755, true)) {
          $error_message = 'impossibile creare la directory';
        }
      }
      
      // non ci sono stati errori nella creazione della directory
      if(empty($error_message)) {
        foreach ($_FILES['imgs']['name'] as $key => $image_name) {
          $safe_image_name = basename($image_name);
          $target_file = $target_dir . $safe_image_name;

          // controlla eventuali errori di caricamento 
          if($_FILES['imgs']['error'][$key] !== UPLOAD_ERR_OK) {
            $error_message = 'errore di caricamento per il file ' . htmlspecialchars($image_name) . ': codice ' . $_FILES['imgs']['error'][$key];
            break;

          }
          if(move_uploaded_file($_FILES['imgs']['tmp_name'][$key], $target_file)) {
            $uploaded_image_details[] = ['name' => $safe_image_name, 'path' => $target_file];

          }else{
            $error_message = 'si è verificato un errore durante il caricamento dell\'immagine: ' . htmlspecialchars($image_name);
            break;

          }
        }
      }
    }

    if(empty($error_message)) {
      // chiamata al metodo addProject e gestione del risultato
      $add_result = $projectOperations->addProject($titolo, $descrizione_breve, $descrizione_completa, $stato, $uploaded_image_details);

      if($add_result === true) { // progetto aggiunto con successo
        $_SESSION['message'] = 'Progetto aggiunto con successo!';
        header("Location: dashboard.php");
        exit();

      }elseif ($add_result === "duplicate_title") { // titolo duplicato rilevato dalla classe Project
        $error_message = 'errore: il titolo del progetto "' . htmlspecialchars($titolo) . '" esiste già. scegli un titolo diverso.';

      }else{
        $error_message = 'errore durante aggiunta del progetto al database.';

      }
    }
  }

  // gestione dell'eliminazione di un progetto
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_project') {
    $project_id_to_delete = $_POST['project_id'];
    if($project_id_to_delete) {

      if($projectOperations->deleteProject($project_id_to_delete)) {
        $success_message = 'progetto eliminato con successo!';

      }else{
        $error_message = 'errore durante l\'eliminazione del progetto.';

      }
    }
  }

  // recupera tutti i progetti esistenti
  $existingProjects = $projectOperations->getAllProjects();

  // recupera tutti gli utenti
  $users = $userOperations->getAllUsers();

  $conn->close();
  ?>
    <div class="container mx-auto">
    <div class="flex items-center justify-center mb-8  gap-x-4">
      <h1 class="text-3xl font-bold">Admin Dashboard</h1>
      <a href="/index.php" title="torna alla home page" class="text-xl">
        <i class="fa-solid fa-house" title="torna alla home"></i>
      </a>
    </div>

    <!--toasts-->
    <?php if (!empty($success_message)): ?>
      <div id="phpSuccessToast" class="toast success show">
        <div class="flex items-center">
          <div class="w-6 h-6 mr-2 flex items-center justify-center">
            <i class="ri-check-line ri-lg"></i>
          </div>
          <span><?php echo $success_message; ?></span>
        </div>
      </div>
    <?php endif; ?>

    <?php if (!empty($error_message)): ?>
      <div id="phpErrorToast" class="toast error show">
        <div class="flex items-center">
          <div class="w-6 h-6 mr-2 flex items-center justify-center">
            <i class="ri-error-warning-line ri-lg"></i>
          </div>
          <span><?php echo $error_message; ?></span>
        </div>
      </div>
    <?php endif; ?>

    <div class="flex gap-6 mb-8">
      <div class="w-1/2 bg-gray-800 rounded-lg shadow-md p-6 text-white">
        <h2 class="text-2xl font-semibold mb-4">Progetti Esistenti</h2>
        <ul class="space-y-3" id="project-list">
          <?php if (!empty($existingProjects)): ?>
            <?php foreach ($existingProjects as $project): ?>
              <li class="bg-gray-700 p-3 rounded flex justify-between items-center">
                <span><?php echo htmlspecialchars($project['titolo']); ?> (creato il: <?php echo date("d/m/Y", strtotime($project['data_creazione'])); ?>)</span>
                <form method="POST" style="display:inline;" onsubmit="return confirm('sei sicuro di voler eliminare questo progetto?');">
                  <input type="hidden" name="action" value="delete_project">
                  <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                  <button type="submit" class="w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600" title="elimina progetto">
                    <i class="ri-delete-bin-line ri-lg"></i>
                  </button>
                </form>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="bg-gray-700 p-3 rounded">nessun progetto trovato.</li>
          <?php endif; ?>
        </ul>
      </div>

      <div id="successToast" class="toast success">
        <div class="flex items-center">
          <div class="w-6 h-6 mr-2 flex items-center justify-center">
            <i class="ri-check-line ri-lg"></i>
          </div>
          <span id="successMessage">operazione completata con successo!</span>
        </div>
      </div>
      
      <div id="errorToast" class="toast error">
        <div class="flex items-center">
          <div class="w-6 h-6 mr-2 flex items-center justify-center">
            <i class="ri-error-warning-line ri-lg"></i>
          </div>
          <span id="errorMessage">si è verificato un errore!</span>
        </div>
      </div>

      <div class="w-1/2 bg-gray-800 rounded-lg shadow-md p-6 text-white">
        <h2 class="text-2xl font-bold mb-6">Nuovo Progetto</h2>
        <form id="project-form" method="POST" enctype="multipart/form-data">
          <input type="hidden" name="action" value="add_project">
          <div class="mb-4">
            <label for="title" class="block mb-2">titolo</label>
            <input type="text" id="title" name="title" class="input w-full" placeholder="titolo progetto" required/>
          </div>
          <div class="mb-4">
            <label for="desc" class="block mb-2">descrizione</label>
            <input type="text" id="desc" name="desc" class="input w-full" placeholder="breve descrizione" maxlength="150" required/>
          </div>
          <div class="mb-4">
            <label for="full" class="block mb-2">descrizione completa</label>
            <textarea id="full" name="full" rows="5" class="input resize-none w-full" placeholder="descrizione dettagliata" required></textarea>
          </div>
          <div class="mb-6">
            <label class="block mb-2">immagini <span id="imgCount" class="text-sm text-gray-400">(0/10)</span></label>
            <div class="w-full mb-4">
              <label for="imgs" class="flex items-center justify-center h-32 border-2 border-dashed border-gray-500 rounded cursor-pointer bg-gray-800 hover:bg-gray-700">
                <div class="text-center">
                  <i class="ri-upload-2-line ri-xl"></i>
                  <p class="mt-1 text-sm">carica immagini (max 10)</p>
                </div>
                <input id="imgs" type="file" name="imgs[]" class="hidden" accept="image/*" multiple/>
              </label>
            </div>
            <div id="preview-grid" class="grid grid-cols-5 gap-4"></div>
          </div>
          <div class="mb-4">
            <label class="block mb-2">stato</label>
            <label class="switch">
              <input type="checkbox" id="status" name="status" checked />
              <span class="slider"></span>
            </label>
            <span class="ml-2" id="status-text">attivo</span>
          </div>

          <div class="flex gap-4">
            <button type="submit" class="btn btn-green px-6 py-2 rounded-button">salva</button>
            <button type="reset" class="btn btn-red px-6 py-2 rounded-button">annulla</button>
          </div>
        </form>
      </div>
    </div>

    <!--Sezione gestione utenti-->
    <div class="bg-gray-800 rounded-lg shadow-md p-6 text-white">
      <h2 class="text-2xl font-bold mb-6">utenti</h2>
      <div class="table-wrap overflow-auto">
        <table class="w-full">
          <thead>
            <tr class="border-b border-[var(--color-hover)]">
              <th class="p-4 text-left">nome</th>
              <th class="p-4 text-left">cognome</th>
              <th class="p-4 text-left">username</th>
              <th class="p-4 text-left">email</th>
              <th class="p-4 text-left">ruolo</th>
              <th class="p-4 text-left">azioni</th>
            </tr>
          </thead>
          <tbody id="users-table-body">
            <?php if (!empty($users)): ?>
              <?php foreach ($users as $user): ?>
                <tr class="row border-b border-[var(--color-hover)]">
                  <td class="py-3 px-4"><?php echo htmlspecialchars($user['name']); ?></td>
                  <td class="py-3 px-4"><?php echo htmlspecialchars($user['surname']); ?></td>
                  <td class="py-3 px-4"><?php echo htmlspecialchars($user['username']); ?></td>
                  <td class="py-3 px-4"><?php echo htmlspecialchars($user['email']); ?></td>
                  <td class="py-3 px-4"><?php echo htmlspecialchars($user['ruolo']); ?></td>
                  <td class="py-3 px-4">
                    <button class="w-8 h-8 flex items-center justify-center text-gray-400 hover:text-primary"><i class="ri-edit-line ri-lg"></i></button>
                    </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="py-3 px-4 text-center">nessun utente trovato.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="/assets/js/dashboard.js"></script>
  <script src="https://kit.fontawesome.com/4383a54113.js" crossorigin="anonymous"></script>
</body>
</html>