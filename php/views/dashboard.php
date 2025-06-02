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
    
<script>
  document.addEventListener("DOMContentLoaded", function () {
      // tutti i campi input 
      const campi = document.querySelectorAll("input[type='text'], textarea");

      campi.forEach(campo => {
        // Ottieni l'ID del campo di input
        const inputId = campo.id;
        // span del contatore corrispondente
        const counterSpan = document.getElementById(`contatore-${inputId}`);

        if(counterSpan){
            const aggiornaContatore = () => {
            const count = campo.value.length;
            counterSpan.textContent = `${count}`; // Aggiorna solo il conteggio
          };

          campo.addEventListener("input", aggiornaContatore);
          aggiornaContatore();
        }
      });
  });
</script>


</head>
<body class="min-h-screen p-6">
  <?php
  session_start();

  require_once __DIR__ . '/../query/database.php';
  require_once __DIR__ . '/../query/user.php';
  require_once __DIR__ . '/../query/project.php';
  require_once __DIR__ . '/../query/operations.php';
  require_once __DIR__ . "/../protected/minimum_authorization_level.php";

	//utente loggato?
	$loggedIn = isset($_SESSION['username']);

	//utente autorizzato per l'accesso alla pagina cpanel?
	if($loggedIn){
		$ruoloId = intval($_SESSION['ruoloId']);

		//livello di autorizzazione richiesto
		$authorized = $ruoloId <= MINIMUM_REQUIRED_AUTHORIZATION_LEVEL;	
    
	}else{
    header('location: pages\login.php');

  }

  $conn = (new database())->connect();
  $userOperations = new user($conn);
  $projectOperations = new project($conn); 
  $operations = new operations($conn);

  $error_message = '';
  $success_message = '';

  // gestione dell'aggiunta di un nuovo progetto
  if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_project') {
    $titolo = $_POST['title'] ?? '';
    $titolo_footer = $_POST['footer-title'] ?? '';
    $descrizione_breve = $_POST['desc'] ?? '';
    $descrizione_completa = $_POST['full'] ?? '';
    $stato = isset($_POST['status']) ? 1 : 0;//conversione da on off a 1 : 0
    //la lista di ruoli che possono visionare il progetto 
    $raggruppamento = $_POST['roles'];
    ///print_r($raggruppamento);
    //exit;
    $uploaded_image_details = [];
    $target_dir = __DIR__ . "/../../assets/uploads/projects/";//percorso

    // gestione delle immagini caricate
    if(isset($_FILES['imgs']) && !empty($_FILES['imgs']['name'][0])) {
      
      if(!is_dir($target_dir)) {
        if(!mkdir($target_dir, 0755, true)) {
          die;
        }
      }
      
      // non ci sono stati errori nella creazione della directory
      if(empty($error_message)) {
        foreach ($_FILES['imgs']['name'] as $key => $original_image_name) {
          
          // Controlla eventuali errori di caricamento PHP prima di procedere
          if($_FILES['imgs']['error'][$key] !== UPLOAD_ERR_OK) {
            $error_message = 'Errore di caricamento per il file ';
            break; 
          }

          // estensione del file
          $file_extension = pathinfo($original_image_name, PATHINFO_EXTENSION);

          // nome del file 
          $filename_without_ext = pathinfo($original_image_name, PATHINFO_FILENAME);

          $unique_filename = $filename_without_ext . '_' . time() . uniqid() . '.' . $file_extension;
          
          $safe_unique_filename = basename($unique_filename);  
          
          $target_file = $target_dir . $safe_unique_filename;

          if(move_uploaded_file($_FILES['imgs']['tmp_name'][$key], $target_file)) {
            $relative_web_path = "assets/uploads/projects/" . $safe_unique_filename;//percorso
            $uploaded_image_details[] = ['name' => $safe_unique_filename, 'path' => $relative_web_path];

          }else{
            $error_message = 'Si è verificato un errore durante il caricamento dell\'immagine: ' . htmlspecialchars($original_image_name);
            break; 
          }
        }
      }
    }

    if(empty($error_message)) {
      // gestione del risultato
      $add_result = $projectOperations->addProject($titolo, $descrizione_breve, $descrizione_completa, $stato, $uploaded_image_details, $titolo_footer, $raggruppamento);

      if($add_result === true) { 
        // progetto aggiunto con successo
        $_SESSION['message'] = 'Progetto aggiunto con successo!';
        header("Location: dashboard.php");
        exit();

      }elseif ($add_result === "duplicate_title") { 
        // titolo duplicato rilevato dalla classe Project
        $error_message = 'Errore: il titolo del progetto "' . htmlspecialchars($titolo) . '" esiste già. Scegli una\'altro titolo diverso.';

      }else{
        $error_message = 'Errore durante l\'aggiunta del progetto al database.';

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

  // tutti i progetti esistenti
  $existingProjects = $projectOperations->getAllProjects();

  // tutti gli utenti
  $users = $userOperations->getAllUsers();

  //tutti i ruoli
  $roles = $operations->getAllRoles();

  $conn->close();
  ?>
    <!--Titolo e home button-->
    <div class="container mx-auto">
      <div class="flex items-center justify-center mb-8  gap-x-4">
        <h1 class="text-3xl font-bold">Admin Dashboard</h1>
        <a href="/index.php" title="torna alla home page" class="text-xl">
          <i class="fa-solid fa-house" title="torna alla home"></i>
        </a>
      </div>

      <!--toasts & messages-->
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

      <!--Progetti esistenti-->
      <div class="flex gap-6 mb-8">
      <div class="w-1/2 bg-gray-800 rounded-lg shadow-md p-6 text-white z" id="new_project">
        <h2 class="text-2xl font-semibold mb-4">Progetti Esistenti</h2>
        <ul class="space-y-3" id="project-list">
          <?php if (!empty($existingProjects)): ?>
            <?php foreach ($existingProjects as $project): ?>
              <li class="bg-gray-700 p-3 rounded flex justify-between items-center">
                <span><?php echo htmlspecialchars($project['titolo']); ?> (creato il: <?php echo date("d/m/Y", strtotime($project['data_creazione'])); ?>)</span>

                <!--Conferma eliminazione con action request allert-->
                <div class="flex items-center gap-[5px]">
                  <!--Link al progetto-->
                  <button onclick="window.location.href='/../index.php?page=project&id=<?php echo htmlspecialchars($project['id'])?>'" class="w-8 h-8 flex items-center justify-center text-green-400 hover:text-green-600" title="vai al progetto">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                  </button>

                  <!--Elimina progetto-->
                  <form method="POST" style="display:inline;" onsubmit="return confirm('sei sicuro di voler eliminare questo progetto?');">

                    <input type="hidden" name="action" value="delete_project">

                    <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                    
                    <button type="submit" class="w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-600" title="elimina progetto">
                      <i class="ri-delete-bin-line ri-lg"></i>

                    </button>
                  </form>

                </div>

              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li class="bg-gray-700 p-3 rounded">nessun progetto trovato.</li>
          <?php endif; ?>
        </ul>
      </div>

      <!--Nuovo progetto-->
      <div class="w-1/2 bg-gray-800 rounded-lg shadow-md p-6 text-white">
        <h2 class="text-2xl font-bold mb-6">Nuovo Progetto</h2>
        
        <form id="project-form" method="POST" enctype="multipart/form-data">

          <input type="hidden" name="action" value="add_project">

          <div class="mb-4">
            <label for="title" class="block mb-2">Titolo</label>
            <p class="text-gray-400">Caratteri: <span id="contatore-title" class="contatore">0</span> / 30</p>
            <input type="text" id="title" name="title" class="input w-full" placeholder="Titolo progetto (massimo 30 caratteri)" maxlength="30" required />
          </div>

          <div class="mb-4">
            <label for="footer-title" class="block mb-2">Titolo per footer</label>
            <p class="text-gray-400">Caratteri: <span id="contatore-footer-title" class="contatore">0</span> / 20</p>
            <input type="text" id="footer-title" name="footer-title" class="input w-full" placeholder="Descrizione breve (massimo 20 caratteri)" maxlength="20" required />
          </div>

          <div class="mb-4">
            <label for="desc" class="block mb-2">Descrizione</label>
            <p class="text-gray-400">Caratteri: <span id="contatore-project-description" class="contatore">0</span> / 50</p>
            <input type="text" id="project-description" name="desc" class="input w-full" placeholder="Descrizione breve (massimo 50 caratteri)" maxlength="50" required />
          </div>

          <div class="mb-4">
            <label for="full" class="block mb-2">descrizione completa</label>
            <p class="text-gray-400">Caratteri: <span id="contatore-full" class="contatore">0</span> / 500</p>
            <textarea id="full" name="full" rows="5" class="input resize-none w-full" placeholder="descrizione dettagliata (massimo 500 caratteri)" maxlength="500" required></textarea>
          </div>

          <div class="mb-6">
            <label class="block mb-2 text-gray-400">immagini <span id="imgCount" class="text-sm text-gray-400">(0/10)</span></label>
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

          <!--Stato progetto-->
          <div class="mb-4">
            <label class="block mb-2">stato progetto</label>
              <label class="switch">
              <input type="checkbox" id="status" name="status" checked />
              <span class="slider"></span>
            </label>
            <span class="ml-2" id="status-text">attivo</span>
          </div>

          <!--Raggruppamento visualizzazione progetto-->
          <div class="mb-4 relative inline-block">
            <label class="block mb-2">Visualizza Progetto Per Ruoli</label>
            <div class="roles-dropdown-trigger input" id="selected-roles-display">
              Seleziona Ruoli
            </div>
            <!--lista di tutti i ruoli-->
            <!--Mostra solo la lista dei ruoli al di sotto del MINIMUM_REQUIRED_AUTHORIZATION_LEVEL dei ruoli che amministratore che possono vedere tutti i progetti a prescindere-->
            <div class="roles-dropdown-content" id="roles-options">
              <?php 
                foreach ($roles as $role): 
                if(intval($role['id']) > MINIMUM_REQUIRED_AUTHORIZATION_LEVEL){
                  ?>
                    <label class="block">
                      <input type="checkbox" name="roles[]" value="<?= $role['id'] ?>" data-label="<?= htmlspecialchars($role['ruolo']) ?>">
                      <?= htmlspecialchars($role['ruolo']) ?>
                    </label>
                  <?php
                }
                endforeach; 
              ?>
            </div>

            <!--<input type="hidden" name="selected_roles_hidden" id="selected-roles-hidden">-->
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