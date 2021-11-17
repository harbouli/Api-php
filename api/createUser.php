<?php
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
    if (!empty($data->firstname) && !empty($data->email) && !empty($data->password) && !empty($data->lastname)) {
        $usersObj->firstname = $data->firstname;
        $usersObj->lastname = $data->lastname;
        $usersObj->email = $data->email;
        $usersObj->password = password_hash($data->password , PASSWORD_DEFAULT);
        $email_data = $usersObj->email_Cheker();

        if(!empty($email_data)){
                http_response_code(403);
                echo json_encode(array(
                "status"=> 403,
                "message"=> "User Is Already Exist"
                ));

        }else{
            if($usersObj->create_user()){
                http_response_code(200);
                echo json_encode(array(
                "status"=> 200,
                "message"=> "Done. User Created"
                ));
            }else{
                http_response_code(500);
                echo json_encode(array(
                "status"=> 500,
                "message"=> "Field To Save User"
            ));
            }
        }


    }else{
        http_response_code(500);
        echo json_encode(array(
            "status"=> 500,
            "message"=> "All Data Needed"
        ));
    };




}else{
    http_response_code(503);
    echo json_encode(array(
        "status"=> 503,
        "message"=> "Access Denied"
    ));
}