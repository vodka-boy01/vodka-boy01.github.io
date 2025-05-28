<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/colors-purple.css">
    <script src="assets/js/load.js"></script>
    <title>Portfolio Tanzillo</title>
</head>
<body>
    <!-- Loading Screen & spinner-->
    <div class="loading-screen">
        <div class="spinner"></div>
    </div>

    <!-- Header -->
    <?php include "includes/header.php"; ?>

    <!-- Contenuto dinamico -->
        <main>
        <?php
            $page = $_GET['page'] ?? 'home';

            if($page === 'profile') {
                include 'pages/profile.php';

            }elseif ($page === 'about') {
                include 'pages/about.php';

            }elseif ($page === 'projects') {
                include 'pages/projects.php';

            }elseif ($page === 'contact') {
                include 'pages/contact.php';

            }elseif ($page === 'home') {
                include 'pages/home.php';

            }elseif (($page === 'mysqlInfinity') && ($_SESSION['ruolo'] === "admin")) {
                header("Location: https://php-myadmin.net/db_structure.php?db=if0_38885359_luigi_tanzillo");
                // echo '<iframe src="https://php-myadmin.net/db_structure.php?db=if0_38885359_luigi_tanzillo" frameborder="0"></iframe>';
                
            }else if(($page === 'mysqlLocal') && ($_SESSION['ruolo'] === "admin")){
                header("Location: http://localhost/phpmyadmin/");
                
            }else if(($page === 'dashboard') && ($_SESSION['ruolo'] === "admin")){
                include 'php\views\dashboard.php';
                
            }else {
                include 'pages/home.php';

            }
        ?> 
        </main>
    <!-- Footer -->
    <?php include "includes/footer.php"; ?>

    <script src="assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/4383a54113.js" crossorigin="anonymous"></script>
</body>
</html>
