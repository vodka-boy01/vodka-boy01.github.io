<style>
	#testo12{
		padding: 20px;
	}
</style>
<?php

  require_once __DIR__ . '/../php/query/database.php';
  require_once __DIR__ . '/../php/query/project.php';
  require_once __DIR__ . '/../php/query/user.php';

  $conn = (new database())->connect();
  $userOperations = new user($conn);
  $projectOperations = new project($conn); 
  
  // Recupera tutti i progetti dal database
  $projects = $projectOperations->getAllProjects();

  $conn->close();

?>
<section class="image-slider">
    <div id="slider-title">
        <h1>I miei progetti</h1> 
    </div>

    <div class="slider-container" id="projectSlider">
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <div class="slide">
                    <div class="project-card">
                        <h1><?php echo htmlspecialchars($project['titolo']); ?></h1>

                        <div class="main-project-image-container">
                            <?php
                            // prima immagine con alt custom 
                            $main_image_src = !empty($project['images'][0]['path']) ? htmlspecialchars($project['images'][0]['path']) : 'https://placehold.co/500x300/333/ffffff?text=Immagine+Non+Disponibile';
                            ?>
                            <img src="<?php echo $main_image_src; ?>" alt="<?php echo htmlspecialchars($project['titolo']); ?>" class="main-project-image">
                        </div>

                        <?php if (!empty($project['images'])): ?>
                            <div class="project-images">
                                <?php
								//numero massimo di immagini una sopra laltra
                                $max = 0;
                                foreach (array_slice($project['images'], 0, $max) as $index => $image):
                                ?>
                                    <img src="<?php echo htmlspecialchars($image['path']); ?>" alt="Thumbnail <?php echo $index + 1; ?>"
                                        class="thumbnail-image <?php echo ($index === 0) ? 'active-thumbnail' : ''; ?>"
                                        data-main-image-target=".main-project-image">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <p class="short-description"><?php echo htmlspecialchars($project['descrizione_breve']); ?></p>
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
