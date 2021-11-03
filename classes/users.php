<?php
class Users {
    public $firstname;
    public $lastname;
    public $email;
    public $password;

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
      public function email_Cheker(){
        $email_query = "SELECT * from ". $this->tbl_users ." WHERE email = ?";

        $usersObj = $this->conn->prepare($email_query);

        $usersObj-> bind_param("s", $this ->email);

        if($usersObj->execute()){
          $data = $usersObj->get_result();

          return $data->fetch_assoc();
        }
        return array();

      }
      public function login_Cheker(){
        $login_query = "SELECT * from ". $this->tbl_users ." WHERE email = ?";

        $usersObj = $this->conn->prepare($login_query);

        $usersObj-> bind_param("s", $this ->email, );

        if($usersObj->execute()){
          $data = $usersObj->get_result();

          return $data->fetch_assoc();
        }
        return array();
      }
      
}