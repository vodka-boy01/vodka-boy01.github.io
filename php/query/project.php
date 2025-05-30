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
                    // ATTENZIONE: Questo percorso file è quello che viene salvato nel DB.
                    // Deve essere il percorso web relativo per l'accesso frontend.
                    // Assicurati che $image['path'] da dashboard.php sia già il percorso web corretto (es. "assets/uploads/nome_file.jpg")
                    // Se $image['path'] contiene già il percorso web, non usare basename() qui.
                    // L'esempio di dashboard.php che ti ho dato usa $relative_web_path = "assets/uploads/" . $safe_unique_filename;
                    // quindi dovresti usare $image['path'] direttamente qui.
                    $relative_web_path = $image['path']; // Usa direttamente il percorso già preparato da dashboard.php

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
                p.id,
                p.titolo,
                p.data_creazione,
                p.descrizione_breve,
                p.descrizione_completa,
                GROUP_CONCAT(CONCAT(img.percorso_file, '|||', img.nome_file) ORDER BY img.id ASC) AS immagini_details
            FROM progetti p
            LEFT JOIN immagini_progetti img ON p.id = img.progetto_id
            GROUP BY p.id, p.titolo, p.data_creazione, p.descrizione_breve, p.descrizione_completa
            ORDER BY p.data_creazione DESC
        ";

        $resSet = $this->connection->query($query);
        $projects = [];

        while($row = $resSet->fetch_assoc()) {
            $project_data = [
                'id' => $row['id'],
                'titolo' => $row['titolo'],
                'data_creazione' => $row['data_creazione'],
                'descrizione_breve' => $row['descrizione_breve'],
                'descrizione_completa' => $row['descrizione_completa'],
                'images' => []
            ];

            if (!empty($row['immagini_details'])) {
                $all_image_details = explode(',', $row['immagini_details']);

                foreach ($all_image_details as $image_detail_string) {
                    $parts = explode('|||', $image_detail_string);
                    if (count($parts) === 2) {
                        $project_data['images'][] = [
                            'path' => trim($parts[0]),
                            'name' => trim($parts[1])
                        ];
                    }
                }
            }
            $projects[] = $project_data;
        }

        return $projects;
    }

    /**
     * Recupera i percorsi completi delle immagini associate a un progetto.
     * Questo metodo è privato e usato internamente.
     * @param int $project_id l'id del progetto.
     * @return array un array di percorsi completi dei file.
     */
    private function getProjectImageFullPaths($project_id) {
        $paths = [];
        $query = "SELECT percorso_file FROM immagini_progetti WHERE progetto_id = ?";
        $resSet = $this->connection->prepare($query);

        if ($resSet === false) {
            error_log("Errore nella preparazione della query per recuperare i percorsi immagine: " . $this->connection->error);
            return [];
        }

        $resSet->bind_param("i", $project_id);
        $resSet->execute();
        $result = $resSet->get_result();

        while ($row = $result->fetch_assoc()) {
            // Ricostruisci il percorso fisico completo del file
            // Assumi che il "percorso_file" nel DB sia relativo alla root web (es. assets/uploads/nome_file.jpg)
            // e che la root web sia 3 livelli sopra la directory di questa classe (Project.php)
            $base_dir = __DIR__ . "/../../"; // Risale a luigi-tanzillo.com/
            $full_path = realpath($base_dir . $row['percorso_file']); // Combina con il percorso relativo dal DB

            if ($full_path !== false) { // Assicurati che il percorso sia valido
                $paths[] = $full_path;
            }
        }
        $resSet->close();
        return $paths;
    }

    /**
     * Elimina un progetto dal database e i suoi file associati dal file system.
     * Utilizza ON Delete cascadee
     * @param int $project_id l'id del progetto da eliminare.
     * @return bool true se l'eliminazione ha successo, false altrimenti.
     */
    public function deleteProject($project_id) {
        // Avvio transazione
        $this->connection->begin_transaction();
        try {
            // 1. Recupera i percorsi delle immagini PRIMA di eliminare il progetto dal DB
            $images_path = $this->getProjectImageFullPaths($project_id);

            // 2. Elimina il progetto dal database cascade
            $query = "DELETE FROM progetti WHERE id = ?";
            $resSet = $this->connection->prepare($query);
            
            $resSet->bind_param("i", $project_id);
            
            if(!$resSet->execute()) {
                throw new Exception("Errore durante l'eliminazione del progetto: " . $resSet->error);
            }
            $resSet->close();

            $this->connection->commit(); // Commit della transazione DB

            // 3. Elimina fisicamente i file dal server
            foreach ($images_path as $file_path) {
                if (file_exists($file_path)) {
                    if (!unlink($file_path)) {
                        error_log("Errore: impossibile eliminare il file " . htmlspecialchars($file_path));
                    }
                } else {
                    error_log("Avviso: il file " . htmlspecialchars($file_path) . " non esiste sul file system, ma era nel DB.");
                }
            }

            return true;
        } catch(Exception $e) {
            $this->connection->rollback(); 
            error_log("Errore in deleteProject: " . $e->getMessage()); 
            return false;
        }
    }
    
}
?>