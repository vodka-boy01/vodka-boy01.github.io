<?php
/**
 * questa classe gestisce le operazioni sui progetti nel database.
 */
class Operations {
    private $connection;

    /**
     * @param mysqli $db connessione al database.
     */
    public function __construct($db) {
        $this->connection = $db;
    }

    function getAllRoles() {
        $query = "
            SELECT
                r.id,
                r.nome AS ruolo
            FROM ruoli r
        ";

        $resSet = $this->connection->query($query);
        
        $roles = [];

        if ($resSet && $resSet->num_rows > 0) {
            while ($row = $resSet->fetch_assoc()) {
                $roles[] = $row;
            }
        }

        return $roles;
    }

}
?>