<?php
$hostname = "localhost";
$username = "root"; 
$password = "";
$database = "loginsito"; 

try {
    $conn = new mysqli($hostname, $username, $password, $database);
} catch (Exception $e) {
    echo "Errore di accesso al database: " . $e->getMessage();
    exit();
}

if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_name = $_POST['new_name'];
    $new_surname = $_POST['new_surname'];
    $new_username = $_POST['new_username'];
    $new_email = $_POST['new_email'];
    $new_password = $_POST['new_password'];

    try{
        $queryVerificaUsername = 'SELECT * FROM utenti WHERE username="' .$new_username.'"';
    }catch(Exception $e){
        echo "Errore di accesso al database: " . $e->getMessage();
        exit();
    }
    $risposta = $conn->query($queryVerificaUsername);

    if($risposta->num_rows == 0){
        //utente non esistente
        // query per inserire un nuovo utente nel database
        $queryInserimento = "INSERT INTO utenti (name, surname, username, email, password) VALUES ('$new_name', '$new_surname', '$new_username', '$new_email', '$new_password')";
        //verifica registrazione
        if ($conn->query($queryInserimento) === TRUE) {
            echo "Registrazione completata con successo!";
        } else {
            echo "Errore durante la registrazione: " . $conn->error;
        }
    }else{
        //utente gia esistente
        echo "utete gia' presente nel sistema";
        $conn->close();
        exit();
    }
}

$conn->close();
?>