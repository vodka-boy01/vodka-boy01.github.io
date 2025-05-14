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
        <?php
			$page = $_GET['page'] ?? 'home';

			switch ($page) {
				case 'about':
					include 'pages/about.php';
				break;
				case 'projects':
					include 'pages/projects.php';
				break;
				case 'contact':
					include 'pages/contact.php';
				break;
				case 'home':
                    include 'pages/home.php';
                break;
                
				default:
					include 'pages/home.php';
				break;
			}
        ?> 
    <!-- Footer -->
    <?php include "includes/footer.php"; ?>

    <script src="assets/js/script.js"></script>
    <script src="https://kit.fontawesome.com/4383a54113.js" crossorigin="anonymous"></script>
</body>
</html>
