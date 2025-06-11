<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/colors-purple.css">
    <script src="assets/js/script.js"></script>
    <!--<script src="assets/js/load.js"></script>-->
    <title>Portfolio Tanzillo</title>
</head>
<body>
    <!-- Loading Screen & spinner-->
    <div class="loading-screen">
        <div class="spinner"></div>
    </div>
    <!-- Header -->
    <?php 
    	require_once __DIR__ . "../php/protected/minimum_authorization_level.php";
    	require_once __DIR__ . "../php/query/database.php";
    	require_once __DIR__ . "../php/query/operations.php";
    	require_once __DIR__ . "../php/query/project.php";
    	require_once __DIR__ . "../php/query/user.php";
        session_start(); 
        $loggedIn = isset($_SESSION['username']);

		//utente autorizzato per l'accesso alla pagina cpanel?
		if($loggedIn){
			$ruoloId = intval($_SESSION['ruoloId']);

			//livello di autorizzazione richiesto
			$authorized = $ruoloId <= MINIMUM_REQUIRED_AUTHORIZATION_LEVEL;	

		}

        //pagina da includere
        $page = $_GET['page'] ?? 'home';

        //header solo per home page
        //header small per le altre pagine
        if($page === 'home' || $page === ' '){
            include "includes/header.php"; 

        }else{
            include "includes/headerSmall.php"; 

        }
    
    ?>

    <!-- Contenuto dinamico -->
        <main>
            <?php
                if($page === 'profile') {
                    include 'pages/profile.php';

                }elseif ($page === 'about') {
                    include 'pages/about.php';

                }elseif ($page === 'projects') {
                    include 'pages/projects.php';

                }elseif ($page === 'events') {
                    include 'pages/projects.php';

                }elseif ($page === 'contact') {
                    include 'pages/contact.php';

                }elseif ($page === 'home') {
                    include 'pages/home.php';

                }elseif (($page === 'mysqlInfinity') && ($loggedIn && $authorized)) {
                    header("Location: https://php-myadmin.net/db_structure.php?db=if0_38885359_luigi_tanzillo");
                    // echo '<iframe src="https://php-myadmin.net/db_structure.php?db=if0_38885359_luigi_tanzillo" frameborder="0"></iframe>';
                    
                }else if(($page === 'mysqlLocal') && ($loggedIn && $authorized)){
                    header("Location: http://localhost/phpmyadmin/");
                    
                }else if(($page === 'phpInfo') && ($loggedIn && $authorized)){
                    header("Location: pages/phpInfo.php");
                    
                }else if(($page === 'dashboard') && ($loggedIn && $authorized)){
                    //include 'php\views\dashboard.php';
                    //echo '<script>window.open("php/views/dashboard.php", "_blank");</script>';
                    header("Location: php/views/dashboard.php");
                    
                }else if($page === 'project'){
                    include 'pages/project_selective.php';

                }else {
                    include 'pages/home.php';

                }
            ?> 
        </main>
    <!-- Footer -->
    <?php include "includes/footer.php"; ?>

    <script src="https://kit.fontawesome.com/4383a54113.js" crossorigin="anonymous"></script>
</body>
</html>