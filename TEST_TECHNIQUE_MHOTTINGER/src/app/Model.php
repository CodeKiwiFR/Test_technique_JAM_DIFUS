<?php
// All our models will implement that abstract class
abstract class Model {
    // Connection props
    protected $_connection;

    // Requests infos
    public $table;

    // Creating the DB connection
    public function getConnection() {
        global $DB_DSN, $DB_PASSWORD, $DB_USER;

        $this->_connection = null;
        try {
            $this->_connection = new PDO(
                $DB_DSN,
                $DB_USER,
                $DB_PASSWORD,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            echo "Erreur: " . $e->getMessage();
        }
    }

    public function getAll() {
        $sql = "SELECT * FROM " . $this->table;
        $query = $this->_connection->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function getOne($id) {
        $sql = "SELECT * FROM " . $this->table . " WHERE " . $this->prefix . "id = :id;";
        $query = $this->_connection->prepare($sql);
        $query->execute(array("id" => $id));
        return $query->fetch();
    }
}