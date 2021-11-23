<?php


require('../vendor/autoload.php');
use \Firebase\JWT\JWT;



header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// including files
include_once('../config/db.php');
include_once('../classes/users.php');

// Object

$db = new Database();
$connection = $db->connect();
$usersObj = new Users($connection);

if($_SERVER['REQUEST_METHOD'] === "POST"){
    $data = json_decode(file_get_contents("php://input"));

    if(!empty($data->email) && !empty($data->password)){
        $usersObj ->email = $data->email;
        
        // $usersObj ->password = $data->password;

        $user_data = $usersObj->login_Cheker();

        if(!empty($user_data)){

            $firstname = $user_data['firstname'];
            $lastname = $user_data['lastname'];
            $email = $user_data['email'];
            $password = $user_data['password'];

            if(password_verify($data->password, $password)){

                // successfully Loged in

                $secret_key = "xDcexyts9e9Bccpt";
                $iss = 'localhost';
                $iat = time();
                $nbf = $iat+ 10;
                $exp = $iat+ 60*60*24*15;
                $aud = 'myUsers';
                $user_data_arry = array(
                    'id' => $user_data['id'],
                    'firstname' => $user_data['firstname'],
                    'lastname' => $user_data['lastname'],
                    'email' => $user_data['email'],
                );
                $payload = array(
                    'iss'=> $iss,
                    'iat'=> $iat,
                    'nbf'=> $nbf,
                    'exp'=> $exp,
                    'aud'=>$aud,
                    'data'=>$user_data_arry
                );
                $jwt =JWT::encode($payload , $secret_key);

                http_response_code(200);
                echo json_encode(array(
                "status"=> 200,
                "jwt" => $jwt,
                "message"=> "User Login Successfully"
                ));
            }else{
                http_response_code(404);
                echo json_encode(array(
                "status"=> 404,
                "message"=> "You Insert Wrong Password Pleas Try Again"
                )); 
            }
        }else{
            http_response_code(404);
            echo json_encode(array(
            "status"=> 404,
            "message"=> "Please Enter Your Password"
            )); 
        }
        
    }else{
        http_response_code(400);
        echo json_encode(array(
        "status"=> 400,
        "message"=> "Please Enter Your Password and Email"
        ));
    }
}else{
    http_response_code(400);
        echo json_encode(array(
        "status"=> 404,
        "message"=> "Page Not Found"
        ));
}