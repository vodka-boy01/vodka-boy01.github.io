	<style>
		nav{
			z-index: 2;
		}
	</style>
<?php
	session_start();
?>
    <header>
		<nav>
			<div id="title_login">
				<div id="nav_title_container">
					<h1 id="nav_title">Web Portfolio Tanzillo</h1>
				</div>
				
				<?php if (!isset($_SESSION[''])): ?>
				<div id="nav_login_container">
					<ul>
						<li><a class="button primary" href="/pages/login.php" title="Accedi al tuo account">Sign In</a></li>
						<li><a class="button primary" href="/pages/registrazione.php" title="Registra un nuovo account">Sing Up</a></li>
					</ul>
					<a id="login-icon" class="fa-solid fa-circle-user" title="Visualizza il tuo profilo"></a>
				</div>
				<?php endif; ?>	

				<?php if (isset($_SESSION['username'])): ?>
				<div id="circle-icon" class="container-colorChange" onclick="colorChange()">
					<i id="light" class="fa-regular fa-sun" title="Cambia tema pagina"></i>
					<i id="dark" class="fa-regular fa-moon" title="Cambia tema pagina"></i>
				</div>
				<?php endif; ?>
			</div>
   
			<hr>

			<div id="nav_bar">
				<div id="nav_links">
					<li><a href="index.php" title="home" class="home-button">Home</a></li>
					<li><a href="index.php?page=about" title= title="Informazioni">About</a></li>
					<li><a href="index.php?page=" title="I miei Progetti">Progetti</a></li>
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