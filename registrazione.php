<?php
$hostname = "localhost"; // Cambia questo con l'host del tuo database
$username = "root"; // Cambia questo con il tuo nome utente del database
$password = ""; // Cambia questo con la tua password del database
$database = "chatgpt"; // Cambia questo con il nome del tuo database

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];

    // Esegui una query per inserire un nuovo utente nel database
    $query = "INSERT INTO utenti (username, password) VALUES ('$new_username', '$new_password')";

    if ($conn->query($query) === TRUE) {
        echo "Registrazione completata con successo!";
    } else {
        echo "Errore durante la registrazione: " . $conn->error;
    }
}

$conn->close();
?>