<?php
class Database{
    //Define DB params
    private $host = 'localhost';
    private $db_name = 'myblog';
    private $user_name = 'root';
    private $password = '';
    private $conn;

    //Set DB connection
    public function connect(){
        $this->conn = null;
        try{
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,
                $this->user_name,$this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e){
            echo 'Connection Error: '.$e->getMessage();
        }
        return $this->conn;
    }
}
?>