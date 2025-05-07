<?php
session_start();

$hostname = "localhost";
$username = "root"; 
$password = "";
$database = "loginsito";

try {
    $conn = new mysqli($hostname, $username, $password, $database);
} catch (Exception $e) {
    echo "Errore di accesso al database: " . $e->getMessage();
}

if ($conn->connect_error) {
    die("Errore di connessione al database: " . $conn->connect_error);
} 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    //query verificare credenziali
    $query = "SELECT * FROM utenti WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $_SESSION['username'] = $username;
        header("location: index.php"); // Reindirizza l'utente
    } else {
        echo "Credenziali non valide. Riprova.";
    }
}

$conn->close();
?>
