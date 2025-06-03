<?php
    $conn = (new database())->connect();
    $userOperations = new user($conn);
    $projectOperations = new project($conn); 
    $userRoleId = $_SESSION['ruoloId'];
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
        $message = $selectedProject['titolo'];

    }else{
        $message =  "Progetto: " . $projectId . " non trovato o non visibile per il tuo ruolo.";

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
                            <img src="<?php echo $image['path']; ?>" alt="<?php echo $image['name']; ?>" class="thumbnail-image <?php echo($index === 0 ? 'active' : ''); ?>">
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
        <h1 style="text-align: center; padding-bottom: 20px; font-size:30px;">Il progetto selezionato non ha contenuti multimediali</h1>
    <?php endif?>
    
    <!--
    <div id="project-images">
        <div class="about-image-right">
            <?php
            // Verifica se l'array 'images' esiste e non è vuoto
            if (!empty($project['images'])) {
                foreach ($project['images'] as $index => $image) {
                    ?>
                    <img src="<?php echo $image['path']; ?>" alt="<?php echo $image['name']; ?>" class="profile-card image-<?php echo $index; ?>">
                    <?php
                }
            } else {
                //fallback image
                ?>
                <img src="assets/img/placeholder.JPEG" alt="Immagine non disponibile" class="profile-card">
                <?php
            }
            ?>
        </div>
    </div>
    -->
    <div class="about-content-wrapper" style="padding-left: 35px;">
        <div class="about-text-left" style="text-align: center;">
            <h2 style="overflow-wrap: break-word;"><?php echo htmlspecialchars($project['titolo'])?></h2><br>
            <p style="text-align: left; overflow-wrap: break-word;"><?php echo htmlspecialchars($project['descrizione_completa'])?></p>
            
        </div>
    </div>

</section>

<div id="page-title">
    <h1>altri progetti consigliati</h1>
</div>

<?php
    include 'includes/projects_slider.php';
?>