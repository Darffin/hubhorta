<?php

include_once('DaoFactory.php');
include_once('PostgresUsuarioDao.php');
include_once('PostgresGerenciadorDao.php');
include_once('PostgresHortaDao.php');

class PostgresDaofactory extends DaoFactory {

    // specify your own database credentials
    private $host = "localhost";
    private $db_name = "HubHorta";
    private $port = "5432";
    private $username = "postgres";
    private $password = "root";
    public $conn;
  
    // get the database connection
    public function getConnection(){
  
        $this->conn = null;
  
        try{
            $this->conn = new PDO("pgsql:host=" . $this->host . ";port=" . $this->port . ";dbname=" . $this->db_name, $this->username, $this->password);
            //$this->conn = new PDO("pgsql:host=localhost;port=5432;dbname=Loja_Virtual", $this->username, $this->password);
    
      }catch(PDOException $exception){
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }

    public function getUsuarioDao() {
        return new PostgresUsuarioDao($this->getConnection());
    }

    public function getGerenciadorDao() {
        return new PostgresGerenciadorDao($this->getConnection());
    }

    public function getHortaDao() {
        return new PostgresHortaDao($this->getConnection());
    }
}
?>