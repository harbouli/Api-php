<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require('../vendor/autoload.php');

use \Firebase\JWT\JWT;

$headers = getallheaders();


$returnData = [
    "success" => 0,
    "status" => 401,
    "message" => "Unauthorized"
];
if($_SERVER['REQUEST_METHOD'] === "POST"):
    
    if(array_key_exists('Authorization',$headers) 
        && !empty(trim($headers['Authorization']))
        ):
        $token = explode(" ", trim($headers['Authorization']))[1];
   $jwt_secrect = "xDcexyts9e9Bccpt";
        $decode = JWT::decode($token, $jwt_secrect, array('HS256'));
        http_response_code(404);
                echo json_encode(array(
                "data"=> $decode->data,
                "message"=> "your Data"
                )); 
    endif;


else: echo json_encode($returnData);
endif;