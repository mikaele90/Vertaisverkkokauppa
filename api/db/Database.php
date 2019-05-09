<?php
class Database {
    // DB Params
    private $db_host = 'localhost';
    private $db_name = 'verkkokauppa';
    private $db_username = 'kayttaja';
    private $user_password = 'dbpass';
    private $dblink;

    // DB Connect
    public function connect() {
        $this->dblink = null;

        try {
            $this->dblink = new PDO('mysql:host=' . $this->db_host . ';dbname=' . $this->db_name, $this->db_username, $this->user_password);
            $this->dblink->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->dblink;
    }
}