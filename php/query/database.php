<?php
/**
 * classe per la gestione della connessione al database e delle operazioni su di esso
 * 
 * @author luigi tanzillo
 * @version 1.1
 */
class database{

    /**
     * costruttore per inizializzare la connession
     * 
     * @param null non richiede valori
     */
    public function __construct(){

    }

    /**
     * connessione al database utilizzando le credenziali
     * 
     * @return mysqli oggetto di connessione al database
     */
    public function connect(){
        require_once __DIR__ . "/../protected/credenzialiMySQL.php";

        $connection = new mysqli(HOST, USER, PASSWORD, DATABASE);

        if ($connection->connect_error) {
            die("errore di connessione: " . $connection->connect_error);
        }

        return $connection;
    }
}
?>