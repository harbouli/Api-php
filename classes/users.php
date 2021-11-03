<?php
class Users {
    public $firstname;
    public $lastname;
    public $email;
    public $password;
    public $roles;

    private $conn;
    private $tbl_users;

    public function __construct($db){
        $this->conn =$db;
        $this ->tbl_users = 'tbl_users';
    }
    public function create_user(){

        $user_query = "INSERT INTO ".$this->tbl_users." SET firstname = ?, lastname = ?, email = ?, password = ?";
    
        $usersObj = $this->conn->prepare($user_query);
    
        $usersObj->bind_param("ssss", $this->firstname, $this->lastname, $this->email, $this->password);
    
        if($usersObj->execute()){
          return true;
        }
    
        return false;
      }
}