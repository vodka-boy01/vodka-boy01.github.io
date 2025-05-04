<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        header{
            padding: 0;
            padding-left: 20px;
            padding-right: 20px;
            background-color: transparent !important;
        }
    </style>
</head>
<body>
    <header>
		<nav>
			<div id="nav_bar">
				<div id="nav_links">
					<li><a href="index.php" title="home" class="home-button">Home</a></li>
					<li><a href="index.php?page=about" title= title="Informazioni">About</a></li>
					<li><a href="index.php?page=" title="I miei Progetti">Progetti</a></li>
					<li><a href="index.php?page=" title="Il mio percorso fornativo">didattica</a></li>
					<li><a href="index.php?page=" title="Contattami">Contatti</a></li>
				</div>
                <div id="nav_login_container">
					<ul>
						<li><a class="button primary" href="/public/login.html" title="Accedi al tuo account">Sign In</a></li>
						<li><a class="button primary" href="/public/registrazione.html" title="Registra un nuovo account">Sing Up</a></li>
					</ul>
					<a id="login-icon" class="fa-solid fa-circle-user" title="Visualizza il tuo profilo"></a>
				</div>	
				<div id="circle-icon" class="container-colorChange" onclick="colorChange()">
					<i id="light" class="fa-regular fa-sun" title="Cambia tema pagina"></i>
					<i id="dark" class="fa-regular fa-moon" title="Cambia tema pagina"></i>
				</div>
			</div>
		</nav>
	</header>
</body>
</html>