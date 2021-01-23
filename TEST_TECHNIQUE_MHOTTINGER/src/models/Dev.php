<?php
class Dev extends Model {
    public function __construct() {
        $this->table = "`db_mhotting.t_dev`";
        $this->prefix = "dev_";
        $this->getConnection();
    }

    // Delete a dev according to its id
    public function deleteOne($id) {
        $sql =
            "DELETE FROM `db_mhotting.t_devlang`" .
            "WHERE ((`devlang_idDev` = :idDev));";
        $query = $this->_connection->prepare($sql);
        $query->execute(array("idDev" => $id));
        $sql =
            "DELETE FROM `db_mhotting.t_dev`" .
            "WHERE ((`dev_id` = :id));";
        $query = $this->_connection->prepare($sql);
        $query->execute(array("id" => $id));
    }

    // Getting all the languages masterd by a dev
    public function getLang($id) {
        $sql =
            "SELECT dev_id, lang_name FROM `db_mhotting.t_dev` " .
            "INNER JOIN `db_mhotting.t_devlang` " .
            "ON `db_mhotting.t_devlang`.devlang_idDev = `db_mhotting.t_dev`.dev_id " .
            "INNER JOIN `db_mhotting.t_lang` " .
            "ON `db_mhotting.t_devlang`.devlang_idLanguage = `db_mhotting.t_lang`.lang_id " .
            "WHERE dev_id = :id;";
        $query = $this->_connection->prepare($sql);
        $query->execute(array("id" => $id));
        return $query->fetchAll();
    }

    // Getting all the devs when their prices are less or equal to given price
    public function getAllByPrice($price) {
        $sql = 
            "SELECT * FROM " . $this->table .
            " WHERE dev_price <= :price;";
        $query = $this->_connection->prepare($sql);
        $query->execute(array("price" => $price));
        return $query->fetchAll();
    }
}