<?php

  require_once __DIR__ . '/../php/query/database.php';
  require_once __DIR__ . '/../php/query/project.php';
  require_once __DIR__ . '/../php/query/user.php';

  $conn = (new database())->connect();
  $userOperations = new user($conn);
  $projectOperations = new project($conn); 
  $userRoleId = $_SESSION['ruoloId'] ?? USER_AUTHORIZATION_LEVEL;

  // Recupera tutti i progetti dal database
  $projects = $projectOperations->getAllProjectsByRole($userRoleId);//TODO:verifica funzionalita

  $conn->close();
//TODO: se il raggrupopoamento di visualizzazione del progetto è uguale a null è visualizzabile a tutti, altrimenti solo a quelli presenti nellarray 
?>

<section class="image-slider">
    <div class="slider-container" id="projectSlider">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="slide">
                    <div class="project-card">
                        <h1 id="slider-title" class="project-text"><?php echo htmlspecialchars($project['titolo']); ?></h1>

                        <div class="main-project-image-container">
                            <?php
                            // prima immagine con alt custom 
                            $main_image_src = !empty($project['images'][0]['path']) ? htmlspecialchars($project['images'][0]['path']) : 'https://placehold.co/500x300/333/ffffff?text=Immagine+Non+Disponibile';
                            ?>
                            <!--Immagine cliccabile, link get con id progetto, verso index con p.id-->
							<a href="index.php?page=project&id=<?php echo htmlspecialchars($project['id'])?>" title="Apri scheda Progetto">
                                <!--Prima immagine del progetto-->
                                <img src="<?php echo $main_image_src; ?>" alt="<?php echo htmlspecialchars($project['titolo']); ?>" class="main-project-image">

                            </a>

                        </div>

                        <!--sezione non attiva max=0-->
                        <?php if (!empty($project['images'])): ?>
                            <div class="project-images">
                                <?php
                                    //numero massimo di immagini una sopra laltra
                                    $max = 0;
                                    foreach (array_slice($project['images'], 0, $max) as $index => $image):
                                ?>
                                <img src="<?php echo htmlspecialchars($image['path']); ?>" alt="Thumbnail <?php echo $index + 1; ?>"
                                    class="thumbnail-image <?php echo ($index === 0) ? 'active-thumbnail' : ''; ?>"
                                    data-main-image-target=".main-project-image"
                                >
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <p id="short-description" class="project-text"><?php echo htmlspecialchars($project['descrizione_breve']); ?></p>
                        
                        <a href="index.php?page=project&id=<?php echo htmlspecialchars($project['id'])?>" title="Apri scheda Progetto">
                            <div id="container-link-scheda-progetto">
                                <h3 class="link-scheda-progetto">Apri scheda progetto</h3>
                                <i class="fa-solid fa-arrow-up-right-from-square link-scheda-progetto"></i>
                            </div>
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-gray-400">Nessun progetto trovato.</p>
        <?php endif; ?>
    </div>

    <div class="slider-navigation">
        <button class="nav-button prev-button">❮</button>
        <button class="nav-button next-button">❯</button>
    </div>
</section>
