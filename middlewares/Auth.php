<?php

// including files
include_once('../classes/jwt_Hanler.php');

class Auth extends JwtHandler{

    protected $databese;
    protected $headers;
    protected $token;
    public function __construct($db,$headers) {
        parent::__construct();
        $this->databese = $db;
        $this->headers = $headers;
    }

    
    public function isAuth(){
        if(array_key_exists('Authorization',$this->headers) && !empty(trim($this->headers['Authorization']))){
            $this->token = explode(" ", trim($this->headers['Authorization']));
            if(isset($this->token[1]) && !empty(trim($this->token[1]))){
                
                $data = $this->jwt_decode($this->token[1]);

                if(isset($data['auth']) && isset($data['data']->user_id) && $data['auth']){
                    $user = $this->fetchUser($data['data']->user_id);
                    return $user;
                }
                else{
                        return null;
                }
                // End of isset($this->token[1]) && !empty(trim($this->token[1]))
            }
            else{
                return null;
                }
            // End of isset($this->token[1]) && !empty(trim($this->token[1]))

        }else{
            return null;}
    }


    protected function fetchUser($user_id){
        try{
            $fetch_user_by_id = "SELECT `email` FROM `php_react_api` WHERE `_id`=:_id";
            $query_stmt = $this->databese->prepare($fetch_user_by_id);
            $query_stmt->bindValue(':_id', $user_id,PDO::PARAM_INT);
            $query_stmt->execute();

            if($query_stmt->rowCount()):
                $row = $query_stmt->fetch(PDO::FETCH_ASSOC);
                return [
                    'success' => 1,
                    'status' => 200,
                    'user' => $row
                ];
            else:
                return null;
            endif;
        }
        catch(PDOException $e){
            return null;
        }
    }
    
}

