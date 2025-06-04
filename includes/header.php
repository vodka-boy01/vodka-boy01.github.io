	<style>
		nav{
			z-index: 2;
		}
	</style>
	
	<?php
		//in questo punto su inifinity free il percorso non viene trovato, va definita una cartella di lavoro statica e fatto riferimento li, poi eliminate tutte le chiamamte a classi e inserite nel main 
		//utente loggato?
		$loggedIn = isset($_SESSION['username']);

		//utente autorizzato per l'accesso alla pagina cpanel?
		if($loggedIn){
			$ruoloId = intval($_SESSION['ruoloId']);

			//livello di autorizzazione richiesto
			$authorized = $ruoloId <= MINIMUM_REQUIRED_AUTHORIZATION_LEVEL;	

		}
	?>

    <header>
		<nav>
			<div id="title_login">
				<div id="nav_title_container">
					<h1 id="nav_title">Web Portfolio Tanzillo</h1>
				</div>
				
				<div id="nav_login_container">
					<!--Rimozione bottone login e registrazione in caso l'utente ha effettuato l'accesso-->
					<?php if (!$loggedIn): ?>
					<ul>
						<li><a class="button primary" href="/pages/login.php" title="Accedi al tuo account">Sign In</a></li>
						<li><a class="button primary" href="/pages/registrazione.php" title="Registra un nuovo account">Sing Up</a></li>
					</ul>
					<?php endif; ?>	

					<!--Rimozione benvenuto, nome utente, menu utente, avatar utente in caso l'utente non sia loggato-->
					<?php if($loggedIn): ?>
					<div class="dropdown">
						<h1 class="dropdown-button"><?php echo htmlspecialchars($_SESSION['ruolo']). ' ' . htmlspecialchars($_SESSION['nome']); ?></h1>
						<div class="dropdown-content">
							<a href="index.php?page=profile" title="Visualizza il tuo profilo">Visualizza profilo</a>
							<!--opzioni disponibili solo per gli utenti con ruolo admin e owner-->
							<?php if($loggedIn && $authorized): ?>
								<a href="index.php?page=mysqlInfinity">PhpMyAdmin infinity</a>
								<a href="index.php?page=mysqlLocal">PhpMyAdmin locale</a>
								<a href="index.php?page=dashboard">Admin dashboard</a>
							<?php endif; ?>	
							<a href="includes/logout.php">Logout</a>
						</div>
					</div>
					<a href="index.php?page=profile" id="login-icon" class="fa-solid fa-circle-user" title="Visualizza il tuo profilo"></a>
					<?php endif; ?>	
				</div>

				<div id="circle-icon" class="container-colorChange" onclick="colorChange()">
					<i id="light" class="fa-regular fa-sun" title="Cambia tema pagina"></i>
					<i id="dark" class="fa-regular fa-moon" title="Cambia tema pagina"></i>
				</div>
			</div>
   
			<hr>

			<div id="nav_bar">
				<div id="nav_links">
					<li><a href="index.php" title="home" class="home-button">Home</a></li>
					<li><a href="index.php?page=about" title= title="Informazioni">About</a></li>
					<li><a href="index.php?page=projects" title="I miei Progetti">Progetti</a></li>
					<li><a href="index.php?page=" title="Il mio percorso fornativo">didattica</a></li>
					<li><a href="index.php?page=" title="Contattami">Contatti</a></li>
				</div>
				<div id="nav_searchBar_container">
					<!--<label for="search-bar-title"></label>!-->
					<input type="search" id="search-input" name="q" value="Ricerca" spellcheck="false">
					<button type="reset" id="reset-button" name="q" onclick="clearSearch()" title="Cancella la ricerca"><i class="fa-solid fa-xmark"></i></button>
					<button type="search" id="submit-button" name="q" title="Cerca"><i class="fa-solid fa-magnifying-glass"></i></button>
				</div>
			</div>
		</nav>
	</header>