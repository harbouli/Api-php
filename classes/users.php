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
    public function createUser(){
        $user_query = "INSERT INTO".$this ->tbl_users."SET firstname=?,lastname=?,email=?,password=?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("ssss", $this->firstname,$this->lastname,$this->email,$this->password);

        if($user_obj->execute()){
            return true;
        }
        return false;
    }
}