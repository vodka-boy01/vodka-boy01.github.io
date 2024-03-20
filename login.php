<?php
session_start();

$hostname = "localhost"; // Cambia questo con l'host del tuo database
$username = "root"; // Cambia questo con il tuo nome utente del database
$password = ""; // Cambia questo con la tua password del database
$database = "loginsito"; // Cambia questo con il nome del tuo database

try {
    $conn = new mysqli($hostname, $username, $password, $database);
}
catch(e){
    echo "errore di accesso al database";
}
if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Esegui una query per verificare le credenziali
    $query = "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("location: dashboard.php"); // Reindirizza l'utente a una pagina di successo o al pannello di controllo
    } else {
        echo "Credenziali non valide. Riprova.";
    }
}

$conn->close();
?>
