<?php
   class db{
    private $servername = "localhost";
    private $username = "root";
    private $password = "root"; 
    private $db  = "barber";
    
    public function connectDB(){
      $this->conn = null;
      $conn = mysqli_connect($this->servername,$this->username,$this->password,$this->db);
      return $conn;
    }
}

?>