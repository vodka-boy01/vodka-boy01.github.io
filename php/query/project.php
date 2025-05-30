<?php
/**
 * questa classe gestisce le operazioni sui progetti nel database.
 */
class Project {
    private $connection;

    /**
     * @param mysqli $db connessione al database.
     */
    public function __construct($db) {
        $this->connection = $db;
    }

    /**
     * aggiunge un nuovo progetto e le sue immagini al database.
     * @param string $titolo titolo del progetto.
     * @param string $descrizione_breve breve descrizione.
     * @param string $descrizione_completa descrizione dettagliata.
     * @param int $stato stato del progetto (1=attivo, 0=inattivo).
     * @param array $uploaded_image_details dettagli delle immagini caricate (nome e percorso).
     * @return bool|string true se ha successo, "duplicate_title" se il titolo esiste già, false per altri errori.
     */
    public function addProject($titolo, $descrizione_breve, $descrizione_completa, $stato, $uploaded_image_details = []) {
        // avvio transazione 
        $this->connection->begin_transaction();

        try {
            $query_project = "INSERT INTO progetti (titolo, descrizione_breve, descrizione_completa, stato) VALUES (?, ?, ?, ?)";
            $resSet_project = $this->connection->prepare($query_project);

            $resSet_project->bind_param("sssi", $titolo, $descrizione_breve, $descrizione_completa, $stato);

            if (!$resSet_project->execute()) {
                // titolo duplicato codice 1062
                if($this->connection->errno == 1062) {
                    throw new Exception("il titolo del progetto esiste già.", 1062);

                }else {
                    throw new Exception("errore durante l'inserimento del progetto: " . $resSet_project->error);

                }
            }

            $project_id = $this->connection->insert_id; // id del progetto appena inserito
            $resSet_project->close();

            // inserisce le immagini
            if(!empty($uploaded_image_details)) {
                $query = "INSERT INTO immagini_progetti (progetto_id, nome_file, percorso_file) VALUES (?, ?, ?)";
                $resSet_image = $this->connection->prepare($query);

                if($resSet_image === false) {
                    throw new Exception("errore nella preparazione della query delle immagini: " . $this->connection->error);
                }

                foreach ($uploaded_image_details as $image) {
                    $image_name = $image['name'];
                    // --- PERCORSO CHIAVE RELATIVO---
                    $relative_web_path = "/../../assets/uploads/" . basename($image_name);

                    $resSet_image->bind_param("iss", $project_id, $image_name, $relative_web_path); 
                    if(!$resSet_image->execute()) {
                        throw new Exception("errore durante l'inserimento dell'immagine '" . htmlspecialchars($image_name) . "': " . $resSet_image->error);
                    }
                }
                $resSet_image->close();
            }

            $this->connection->commit();
            return true;

        }catch(Exception $e) {
            $this->connection->rollback(); // rollback in caso di errore
            error_log("errore in addProject: " . $e->getMessage());

            // restituisce "duplicate_title"
            if($e->getCode() == 1062) {
                return "duplicate_title";
            }
            return false;
        }
    }

    /**
     * recupera tutti i progetti dal database.
     * @return array un array di progetti.
     */
    public function getAllProjects() {
        $query = "
            SELECT 
                id, 
                titolo, 
                data_creazione
            FROM progetti 
            ORDER BY data_creazione DESC
            ";
        $result = $this->connection->query($query);
        $projects = [];

        if($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $projects[] = $row;
            }
        }

        return $projects;
    }

    /**
     * TODO: aggiiungere logivca eliminazione livello fisico server file system
     * elimina un progetto dal database.
     * questa funzione NON elimina i file fisici delle immagini dal server.
     * si affida a ON DELETE CASCADE per l'eliminazione dei record delle immagini nel DB.
     * @param int $project_id l'id del progetto da eliminare.
     * @return bool true se l'eliminazione ha successo, false altrimenti.
     */
    public function deleteProject($project_id) {
        // avvio transazione 
        $this->connection->begin_transaction();
        try {
            $query = "DELETE FROM progetti WHERE id = ?";
            $resSet = $this->connection->prepare($query);
            
            if ($resSet === false) {
                throw new Exception("errore nella preparazione della query di eliminazione del progetto: " . $this->connection->error);

            }
            
            $resSet->bind_param("i", $project_id);
            
            if(!$resSet->execute()) {
                throw new Exception("errore durante l'eliminazione del progetto: " . $resSet->error);

            }
            $resSet->close();

            $this->connection->commit();

            return true;
        }catch(Exception $e) {
            $this->connection->rollback(); 
            error_log("errore in deleteProject: " . $e->getMessage()); 

            return false;
        }
    }
    
}
?>