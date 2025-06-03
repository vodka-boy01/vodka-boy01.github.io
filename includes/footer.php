<?php
    $conn = (new database())->connect();
    $projectOperations = new project($conn); 
    
    //id progetto
	$userRoleId = $_SESSION['ruoloId'] ?? 4;

	$allProjects = $projectOperations->getAllProjectsByRole($userRoleId);
	$lastFour = array_slice($allProjects, 0, 4);

	$conn->close();
?>
<footer>
	<div id="footer_links">
		<div class="footer_collumn">
			<h4 class="footer_title_block">Chi sono</h4>
			<hr class="footer_devider_block">
			<ul>
				<li><a href="#">Luigi Tanzillo</a></li>
				<li><a href="#">Studente di Informatica</a></li>
				<li><a href="#">Appassionato di Tecnologia</a></li>
				<li><a href="#">Pilota di Droni</a></li>
			</ul>
		</div>
		
		<div class="footer_collumn">
			<h4 class="footer_title_block">Progetti</h4>
			<hr class="footer_devider_block">
			<ul>
				<?php foreach($lastFour AS $project):?>
					<li>
						<a href="index.php?page=project&id=<?php echo htmlspecialchars($project['id'])?>">
							<?php echo htmlspecialchars($project['titolo_footer'])?>
						</a>
					</li>
				<?php endforeach  ?>
			</ul>
		</div>
		
		<div class="footer_collumn">
			<h4 class="footer_title_block">Percorso</h4>
			<hr class="footer_devider_block">
			<ul>
				<li><a href="#">IT Masullo Theti</a></li>
				<li><a href="#">Diploma Informatica</a></li>
				<li><a href="#">Certificazione Droni</a></li>
				<li><a href="#">Simulazione Volo</a></li>
			</ul>
		</div>
		
		<div class="footer_collumn">
			<h4 class="footer_title_block">Contatti</h4>
			<hr class="footer_devider_block">
			<ul>
				<li><i class="fa fa-user"></i> A cura di Luigi Tanzillo</li>
				<li><i class="fa fa-phone-alt"></i> +39 351 221 8134</li>
				<li><i class="fa fa-envelope"></i> <a href="mailto:luigitanzillo2006@gmail.com">luigitanzillo2006@gmail.com</a></li>
				<li><i class="fa fa-map-marker-alt"></i> Ottaviano (NA)</li>
			</ul>
		</div>
	</div>
	
	<div id="footer_social_row">
		<br>
		<hr class="footer_devider_block">
		<ul id="footer_social_icons">
			<li><a href="https://www.instagram.com" target="_blank" class="footer_icon"><i class="fa-brands fa-instagram"></i></a></li>
			<li><a href="https://it-it.facebook.com" target="_blank" class="footer_icon"><i class="fa-brands fa-facebook-f"></i></a></li>
			<li><a href="https://www.linkedin.com" target="_blank" class="footer_icon"><i class="fa-brands fa-linkedin-in"></i></a></li>
			<li><a href="https://www.github.com" target="_blank" class="footer_icon"><i class="fa-brands fa-github"></i></a></li>
			<li><a href="https://www.youtube.com" target="_blank" class="footer_icon"><i class="fa-brands fa-youtube"></i></a></li>
			<li><a href="https://www.twitch.tv" target="_blank" class="footer_icon"><i class="fa-brands fa-twitch"></i></a></li>
			<li><a href="https://www.discord.com" target="_blank" class="footer_icon"><i class="fa-brands fa-discord"></i></a></li>
			<li><a href="https://www.tiktok.com" target="_blank" class="footer_icon"><i class="fa-brands fa-tiktok"></i></a></li>
			<li><a href="https://www.whatsapp.com" target="_blank" class="footer_icon"><i class="fa-brands fa-whatsapp"></i></a></li>
			<li><a href="https://www.telegram.org" target="_blank" class="footer_icon"><i class="fa-brands fa-telegram"></i></a></li>
		</ul>
	</div>
	<h5 id="Copyright">
		Copyright © 2023-2025 Luigi-Tanzillo.42web.io
		All rights reserved
	</h5>
</footer>