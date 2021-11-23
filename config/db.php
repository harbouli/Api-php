<?php

class Database{

  // variable declaration
  private $hostname;
  private $dbname;
  private $username;
  private $password;
  private $conn;

  public function connect(){
     // variable initialization
     $this->hostname = "localhost";
     $this->dbname = "php_react_api";
     $this->username = "root";
     $this->password = "root";

     $this->conn = new mysqli($this->hostname, $this->username,  $this->password, $this->dbname);
     if($this->conn->connect_errno){
       // true => it means that it has some error
       print_r($this->conn->connect_error);
       exit;
     }else{
       // false => it means no error in connection details
       return $this->conn;
       echo "--successful connection--";
     }
  }
  public function dbConnection(){

    $this->hostname = "localhost";
     $this->dbname = "php_react_api";
     $this->username = "root";
     $this->password = "root";
        
    try{
        $conn = new PDO('mysql:host='.$this->hostname.';dbname='.$this->dbname,$this->username,$this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    }
    catch(PDOException $e){
        echo "Connection error ".$e->getMessage(); 
        exit;
    }
      
}
}
