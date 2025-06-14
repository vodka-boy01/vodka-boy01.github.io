<?php

// --- ATTIVA DEBUGGING PHP ---
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

session_start();

function debug_log($data, $label = '', $exit = false) {
    echo "<div style='background-color: #f0f0f0; border: 1px solid #ccc; padding: 10px; margin: 10px 0; font-family: monospace; font-size: 14px; color: #333;'>";
    if ($label) {
        echo "<strong>" . htmlspecialchars($label) . ":</strong><br>";
    }
    echo "<pre>";
    print_r($data);
    echo "</pre>";
    echo "</div>";
    if ($exit) {
        die("Debug termination.");
    }
}

// --- COSTANTE BASE ---
define('BASE_PHP_DIR', __DIR__ . '/');

// --- CLASSI DA CONTROLLARE ---
$classFiles = [
    'protected/minimum_authorization_level.php',
    'query/database.php',
    'query/operations.php',
    'query/project.php',
    'query/user.php',
];

echo "<h2>Verifica Inclusione Classi:</h2>";
foreach ($classFiles as $file) {
    $filePath = BASE_PHP_DIR . $file;
    if (file_exists($filePath)) {
        require_once $filePath;
        echo "<p style='color: green;'>&#10004; Caricato con successo: <strong>" . htmlspecialchars($filePath) . "</strong></p>";
    } else {
        echo "<div style='color: red; font-weight: bold; padding: 10px; border: 1px solid red; margin-bottom: 10px;'>";
        echo "❌ ERRORE: File mancante: <strong>" . htmlspecialchars($filePath) . "</strong><br>";
        echo "Controlla che il percorso sia corretto e che il file esista.";
        echo "</div>";
    }
}

echo "<hr>";

// --- SESSIONE E LOGIN ---
$loggedIn = isset($_SESSION['username']);
debug_log($_SESSION, '$_SESSION');
debug_log($loggedIn, '$loggedIn');

if ($loggedIn) {
    $ruoloId = intval($_SESSION['ruoloId'] ?? -1);
    $minAuth = defined('MINIMUM_REQUIRED_AUTHORIZATION_LEVEL') ? MINIMUM_REQUIRED_AUTHORIZATION_LEVEL : 'NON DEFINITO';
    $authorized = is_numeric($minAuth) ? $ruoloId <= $minAuth : false;

    debug_log($ruoloId, '$ruoloId');
    debug_log($minAuth, 'MINIMUM_REQUIRED_AUTHORIZATION_LEVEL');
    debug_log($authorized, '$authorized');
} else {
    debug_log("Nessun utente loggato", 'Stato login');
}

echo "<hr>";

// --- PARAMETRO PAGINA ---
$page = $_GET['page'] ?? 'home';
debug_log($page, 'Parametro $_GET[\'page\']');

?>
