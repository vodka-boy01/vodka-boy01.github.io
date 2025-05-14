<?php
$serverName = "web2.keystore.it";
$databaseName = "luigi";
$username = "sa"; 
$password = "eHEW6GxuEzSC4ad5uAvuue";

?>
<?php

$serverName = "web2.keystore.it";
$databaseName = "luigi";
$username = "sa"; 
$password = "eHEW6GxuEzSC4ad5uAvuue";

// Connessione al database
$connectionInfo = array(
    "UID" => $username,
    "PWD" => $password,
    "Database" => $databaseName,
    "Server" => $serverName
);

$conn = sqlsrv_connect($connectionInfo);

if ($conn === false) {
    echo "Errore di connessione al database: " . sqlsrv_errors();
} else {
    echo "Connessione al database avvenuta con successo!";
}

// Chiusura della connessione
sqlsrv_close($conn);

?>