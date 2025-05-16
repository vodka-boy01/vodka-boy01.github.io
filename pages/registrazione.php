<!DOCTYPE html>
<html lang="it">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/assets/css/style_login.css">
	<link rel="stylesheet" href="/assets/css/colors-purple.css">
  <link rel="stylesheet" href="/assets/css/style.css">
	<script src="/assets/js/load.js"></script>
  <title>Pagina di registrazione</title>
</head>
<body>
  <?php
  if(isset($_POST['invia'])){
    require_once "../php/query/database.php";
    require_once "../php/query/user.php";

    session_start();

    //oggetti, connessione e variabili
    $conn = (new database())->connect();
    $userOperations = new user($conn);

    //testo di errore campi form
    $usernameError = '';
    $emailError = '';

    //dati da POST
    $name = $_POST['new_name'];
    $surname = $_POST['new_surname'];
    $username = $_POST['new_username'];
    $email = $_POST['new_email'];
    $password = $_POST['new_password'];
    $avatar = $_POST['new_avatar'];

    //verifica esistenza username
    if($userOperations->existsInField("username", $username)){
      $usernameError = "Username già in uso.";
    }

    //controllo esistenza email
    if($userOperations->existsInField("email", $email)){
      $emailError = "Email già associata ad un account.";
    }

    if($usernameError == '' && $emailError == ''){
      if($userOperations->register($name, $surname, $username, $email, $password)){
        $_SESSION['username'] = $username;
        $_SESSION['nome'] = $name;
        $_SESSION['ruolo'] = $userOperations->getUserRole($username);
        $conn->close();
        header("Location: ../index.php");
        
      }
    }

    $conn->close();
  }
  ?>
  <div class="loading-screen">
    <div class="spinner"></div>
  </div>

  <main class="login-container">
    <h2>REGISTRAZIONE</h2>

    <!--bottoni home e color change-->
    <div id="login_page_buttons">
      <a href="/index.php" title="Torna alla home page"><i class="fa-solid fa-house"></i></a>
      <div id="circle-icon" class="container-colorChange" onclick="colorChange()">
        <i id="light" class="fa-regular fa-sun" title="Cambia tema pagina"></i>
        <i id="dark" class="fa-regular fa-moon" title="Cambia tema pagina"></i>
        <br>
      </div>
    </div>

    <!--form registrazione-->
    <form action="<?php $_SERVER['PHP_SELF']?>" method="post" id="form">
      <!--nome-->
      <label for="new_name">Nome:</label>
      <input type="text" id="new_name" name="new_name" placeholder="Mario" required >

      <!--cognome-->
      <label for="new_surname">Cognome:</label>
      <input type="text" id="new_surname" name="new_surname" placeholder="Rossi" required >

      <!--username-->
      <label for="new_username" class="error_text">Username:</label>
      <input type="text" id="new_username" name="new_username" placeholder="Mario33" required class="
      <?php 
        if(isset($usernameError) && $usernameError != ''){
          echo "error_border";
        }
      ?>">
      <!--username error-->
      <?php if(isset($usernameError) && $usernameError != ''): ?>
        <div class="error_message"><?php echo $usernameError; ?></div>
      <?php endif; ?>

      <!--email-->
      <label for="new_email" class="error_text">Email:</label>
      <input type="email" id="new_email" name="new_email" placeholder="mariorossi@esempio.it" required class="
      <?php 
        if(isset($usernameError) && $usernameError != ''){
          echo "error_border";
        }
      ?>">
      <!--email error-->
      <?php if(isset($emailError) && $emailError != ''): ?>
        <div class="error_message"><?php echo $emailError; ?></div>
      <?php endif; ?>

      <!--password-->
      <label for="new_password">Password:</label>
      <input type="password" id="new_password" name="new_password" placeholder="1234" required >

      <!--avatar-->
      <label for="avatar">Carica un avatar:</label>
      <input type="file" id="new_avatar file" name="new_avatar" accept="image/*">  

      <!--bottone invia-->
      <input type="submit" class="button primary" name="invia">
    </form>
    <p>Hai gia un account?</p>
    <a class="button primary" href="login.php" title="Accedi al tuo account">Accedi</a>
  </main>
  <script src="/assets/js/script_loginPage.js"></script>
  <script src="https://kit.fontawesome.com/4383a54113.js" crossorigin="anonymous"></script>
  <script src="/assets/js/script.js"></script>
</body>
</html>