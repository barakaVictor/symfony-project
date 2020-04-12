<?php
class Database{
    private $host = "localhost";
    private $db_name = "cake_shop";
    private $username = "root";
    private $password = "";
    public $conn;

    public function connectToDb(){
        $this->conn = null;
        try{
            $this->conn = new PDO("mysql:host=" .$this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
        }
        catch(PDOException $e){
            echo "Connection error:".$e->getMessage();
        }
        return $this->conn;
    }
}

?>