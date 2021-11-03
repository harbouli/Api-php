<?php
 ini_set("display_errors",1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json;charset=UTF-8");

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
        
        $usersObj ->password = $data->password;

        $user_data = $usersObj->login_Cheker();

        if(!empty($user_data)){

            $firstname = $user_data['firstname'];
            $lastname = $user_data['lastname'];
            $email = $user_data['email'];
            $password = $user_data['password'];
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
}