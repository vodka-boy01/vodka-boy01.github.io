<?php
/**
 * questa classe gestisce le operazioni sui progetti nel database.
 */
class Project {
    private $connection;

    /**
     * costruttore per inizializzare la connessione al database.
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
        // avvia una transazione per assicurare l'integrità dei dati
        $this->connection->begin_transaction();

        try {
            // prepara e esegui l'inserimento del progetto
            $query_project = "INSERT INTO progetti (titolo, descrizione_breve, descrizione_completa, stato) VALUES (?, ?, ?, ?)";
            $stmt_project = $this->connection->prepare($query_project);

            if ($stmt_project === false) {
                throw new Exception("errore nella preparazione della query del progetto: " . $this->connection->error);
            }

            $stmt_project->bind_param("sssi", $titolo, $descrizione_breve, $descrizione_completa, $stato);

            if (!$stmt_project->execute()) {
                // cattura l'errore per titolo duplicato (codice 1062 di MySQL)
                if ($this->connection->errno == 1062) {
                    throw new Exception("il titolo del progetto esiste già.", 1062);
                } else {
                    throw new Exception("errore durante l'inserimento del progetto: " . $stmt_project->error);
                }
            }

            $project_id = $this->connection->insert_id; // id del progetto appena inserito
            $stmt_project->close();

            // inserisce le immagini, se presenti
            if (!empty($uploaded_image_details)) {
                $query_image = "INSERT INTO immagini_progetti (progetto_id, nome_file, percorso_file) VALUES (?, ?, ?)";
                $stmt_image = $this->connection->prepare($query_image);

                if ($stmt_image === false) {
                    throw new Exception("errore nella preparazione della query delle immagini: " . $this->connection->error);
                }

                foreach ($uploaded_image_details as $image) {
                    $image_name = $image['name'];
                    // --- PERCORSO CHIAVE ---
                    $relative_web_path = "assets/uploads/" . basename($image_name); // Costruiamo il percorso relativo desiderato

                    $stmt_image->bind_param("iss", $project_id, $image_name, $relative_web_path); 
                    if (!$stmt_image->execute()) {
                        throw new Exception("errore durante l'inserimento dell'immagine '" . htmlspecialchars($image_name) . "': " . $stmt_image->error);
                    }
                }
                $stmt_image->close();
            }

            $this->connection->commit(); // conferma la transazione
            return true;

        } catch (Exception $e) {
            $this->connection->rollback(); // annulla la transazione in caso di errore
            error_log("errore in addProject: " . $e->getMessage()); // logga l'errore

            // restituisce "duplicate_title" per errore specifico
            if ($e->getCode() == 1062) {
                return "duplicate_title";
            }
            return false; // restituisce false per altri errori
        }
    }

    /**
     * recupera tutti i progetti dal database.
     * @return array un array di progetti.
     */
    public function getAllProjects() {
        $query = "SELECT id, titolo, data_creazione FROM progetti ORDER BY data_creazione DESC";
        $result = $this->connection->query($query);
        $projects = [];
        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
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
        // avvia una transazione
        $this->connection->begin_transaction();
        try {
            // elimina il progetto dal database
            // grazie a ON DELETE CASCADE, i record delle immagini_progetti verranno eliminati automaticamente
            $query_delete_project = "DELETE FROM progetti WHERE id = ?";
            $stmt_delete_project = $this->connection->prepare($query_delete_project);
            
            if ($stmt_delete_project === false) {
                throw new Exception("errore nella preparazione della query di eliminazione del progetto: " . $this->connection->error);
            }
            
            $stmt_delete_project->bind_param("i", $project_id);
            
            if (!$stmt_delete_project->execute()) {
                throw new Exception("errore durante l'eliminazione del progetto: " . $stmt_delete_project->error);
            }
            $stmt_delete_project->close();

            $this->connection->commit(); // conferma la transazione
            return true;

        } catch (Exception $e) {
            $this->connection->rollback(); // annulla la transazione in caso di errore
            error_log("errore in deleteProject: " . $e->getMessage()); // logga l'errore
            return false;
        }
    }
}
?>