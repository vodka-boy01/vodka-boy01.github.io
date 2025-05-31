<?php
    $image_alt = 'https://placehold.co/500x300/333/ffffff?text=Immagine+Non+Disponibile';

?>
<section id="about" class="about-section">
    <div class="about-content-wrapper">
        <div class="about-text-left">
            <h2>Chi sono</h2>
            <p>Ciao! Sono Luigi Tanzillo, una persona curiosa e appassionata di tutto ciò che riguarda la tecnologia e l’innovazione. Fin da piccolo mi affascinano i computer, gli aerei e la musica. Amo la simulazione di volo, un hobby che porto avanti con oltre 700 ore di esperienza su simulatori avanzati. Sono anche pilota di droni certificato EASA per le categorie A1-A3, una passione che coltivo con serietà e precisione.</p>
            <p>Nel tempo libero suono il pianoforte, una disciplina che mi aiuta a esprimere emozioni e migliorare concentrazione e coordinazione. Mi appassionano i romanzi fantasy e fantascientifici, che alimentano la mia immaginazione. Queste passioni arricchiscono la mia mente, stimolano la mia creatività e si riflettono in ogni attività della mia vita quotidiana.</p>
        </div>

        <div class="about-image-right">
            <img src="assets\img\luigi.JPEG" alt="La tua foto profilo" class="profile-card">
        </div>
    </div>    
    
    <div class="about-content-wrapper">
        <div class="about-text-left">
            <h2>Il mio lavoro</h2>
            <p>Mi occupo con professionalità della riparazione di dispositivi elettronici come telefoni, tablet e hardware su richiesta, offrendo assistenza precisa e personalizzata. Dalla sostituzione di componenti difettosi alla risoluzione di guasti complessi, il mio obiettivo è ridare funzionalità ai dispositivi nel minor tempo possibile, mantenendo standard elevati di qualità e affidabilità.</p>
            <p>In parallelo, progetto e assemblo PC di fascia medio-alta su misura, selezionando accuratamente ogni componente in base alle esigenze del cliente, sia per gaming che per lavoro. Mi concentro su prestazioni, stabilità e ordine interno, curando ogni fase dall’assemblaggio al test finale per offrire sistemi potenti, silenziosi e ottimizzati.</p>
        </div>
    </div>

    <div class="about-content-wrapper">
        <div class="about-text-left">
            <section class="image-slider">
                <div class="slider-container" id="projectSlider">
                    <div class="slide">
                        <div class="project-card">
                            <h1>Build fascia alta gaming</h1>

                            <div class="project-images">
                                <img src="<?php echo $image_alt; ?>" alt=""class="thumbnail-image <?php echo($index === 0); ?>">
                            </div>

                            <p class="short-description">PC da circa 1800 euro</p>
                        </div>
                    </div>

                    <div class="slide">
                        <div class="project-card">
                            <h1>Riparazione Iphone 7</h1>

                            <div class="project-images">
                                <img src="<?php echo $image_alt; ?>" alt=""class="thumbnail-image <?php echo($index === 0); ?>">
                            </div>

                            <p class="short-description">Sostituzione schermo</p>
                        </div>
                    </div>

                    <div class="slide">
                        <div class="project-card">
                            <h1>Riparazione Laptop</h1>

                            <div class="project-images">
                                <img src="<?php echo $image_alt; ?>" alt=""class="thumbnail-image <?php echo($index === 0); ?>">
                            </div>

                            <p class="short-description">Rebuild pc</p>
                        </div>
                    </div>
                </div>

                <div class="slider-navigation">
                    <button class="nav-button prev-button">❮</button>
                    <button class="nav-button next-button">❯</button>
                </div>
            </section>
        </div>
    </div>

    <div class="about-details">
        <h3>Le mie Competenze</h3>
        <div class="skills-grid">
            <div class="skill-item">
                <i class="fas fa-mobile-alt"></i>
                <p>Riparazione Telefoni</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-tablet-alt"></i>
                <p>Riparazione Tablet</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-laptop"></i>
                <p>Riparazione PC</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-tools"></i>
                <p>Diagnosi e Manutenzione</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-microchip"></i>
                <p>Sostituzione Componenti</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-bug"></i>
                <p>Risoluzione Software</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-microchip"></i>
                <p>Elettronica DIY</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-plane"></i>
                <p>Pilota Droni</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-car-side"></i>
                <p>Guida</p>
            </div>

            <div class="skill-item">
                <i class="fas fa-network-wired"></i>
                <p>Cisco networking</p>
            </div>
        </div>

        <h3>Le mie Passioni</h3>
        <div class="passions-list">
            <ul>
                <li><i class="fas fa-camera"></i> Fotografia digitale</li>
                <li><i class="fas fa-gamepad"></i> Videogiochi di strategia</li>
                <li><i class="fas fa-gamepad"></i> Videogiochi gestionali</li>
                <li><i class="fas fa-hiking"></i> Escursionismo e contatto con la natura</li>
                <li><i class="fas fa-code"></i> Programmazione software e sviluppo web</li>
                <li><i class="fas fa-database"></i> Progettazione di sistemi informatici e database</li>
                <li><i class="fas fa-plane-departure"></i> Simulazione di volo e aviazione</li>
                <li><i class="fas fa-microchip"></i> Elettronica e costruzione di circuiti</li>
                <li><i class="fas fa-music"></i> Pianoforte e musica</li>
                <li><i class="fas fa-helicopter"></i> Pilotaggio di droni certificato</li>
                
            </ul>
        </div>
    </div>
</section>