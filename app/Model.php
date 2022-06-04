<?php

abstract class Model
{
    // Informations de la base de données
    private $host = "localhost";
    private $db_name = "api";
    private $username = "root";
    private $password = "";

    protected $_connection;


    public $table;
    public $id;

    public function getConnection()
    {

        $this->_connection = null;
        try {
            $this->_connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->_connection->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Error : " . $exception->getMessage();
        }
    }

    public function getOne()
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id=" . $this->id;
        $query = $this->_connection->prepare($sql);
        $query->execute();
        return $query->fetch();
    }

    public function getAll()
    {
        $sql = "SELECT * FROM " . $this->table . "";
        $query = $this->_connection->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}