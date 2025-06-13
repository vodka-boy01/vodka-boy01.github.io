<?php
    $conn = (new database())->connect();
    $userOperations = new user($conn);
    $projectOperations = new project($conn); 
    $userRoleId = $_SESSION['ruoloId'] ?? GUEST_AUTHORIZATION_LEVEL;
    $message = '';

    //1: recupera tutti i progetti visibili in base al ruolo dell'utente
    $projectsByRole = $projectOperations->getAllProjectsByRole(intval($userRoleId));
    //2: prendi target project id da $_GET 
    $projectId = $_GET['id'];
    //3: progetto scelto
    $selectedProject = null;

    foreach($projectsByRole as $project) {
        if ($project['id'] == $projectId) {
            $selectedProject = $project;
            break;
        }
    }

    if($selectedProject){
        $message = $selectedProject['tipo'] . ": " . $selectedProject['titolo'];

    }else{
        $message = "Progetto: " . $projectId . " non trovato o non visibile per il tuo ruolo.";

    }
    
    $conn->close();
?>

<section id="project-selective">
    <div id="page-title">
        <h1><?php echo $message; ?></h1>
    </div>

    <!--slider immagini progetto-->
    <?php if(!empty($selectedProject['images'])):?>
    <section class="image-slider">
        <div class="slider-container" id="projectSlider">
            <?php foreach ($project['images'] as $index => $image): ?>
                <div class="slide">
                    <div class="project-card">

                        <div class="project-images">
                            <img id="img-full" src="<?php echo $image['path']; ?>" alt="<?php echo $image['name']; ?>" class="thumbnail-image <?php echo($index === 0 ? 'active' : ''); ?>" style=" height: none;">
                        </div>

                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="slider-navigation">
            <button class="nav-button prev-button">❮</button>
            <button class="nav-button next-button">❯</button>
        </div>
    </section>
    <?php else:?>
        <h1 style="text-align: center; padding-bottom: 20px; font-size:30px;">Il progetto selezionato non ha contenuti multimediali allegati</h1>
    <?php endif?>

    <div class="project-info-wrapper" style="padding-left: 35px;">
        <div class="project-info-left" style="text-align: center;">
            <h2 style="overflow-wrap: break-word;"><?php echo htmlspecialchars($project['titolo'])?></h2><br>
            <p style="text-align: left; overflow-wrap: break-word;"><?php echo htmlspecialchars($project['descrizione_completa'])?></p>
            
        </div>
        
        <div class="project-info-right" style="text-align: center;">
            <h2><?php echo htmlspecialchars($project['tipo'])?></h2><br>
            
            <p>ID: <?php echo htmlspecialchars($project['id']) ?></p>
            <p>Tipo: <?php echo htmlspecialchars($project['tipo']) ?></p>
            <p>creato il: <?php echo date("d/m/Y", strtotime($project['data_creazione'])); ?></p>
        </div>
    </div>
</section>

<div id="page-title">
    <h1>altri progetti consigliati</h1>
</div>

<?php
    include 'includes/projects_slider.php';
?>