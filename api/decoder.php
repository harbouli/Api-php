<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require('../vendor/autoload.php');

use \Firebase\JWT\JWT;

$headers = getallheaders();
function msg($success,$status,$message,$extra = []){
    return array_merge([
        'success' => $success,
        'status' => $status,
        'message' => $message
    ],$extra);
}

$returnData = [
    "success" => 0,
    "status" => 401,
    "message" => "Unauthorized"
];

    
    if(array_key_exists('Authorization',$headers) 
        && !empty(trim($headers['Authorization']))
        ):
        $token = explode(" ", trim($headers['Authorization']))[1];
   $jwt_secrect = "xDcexyts9e9Bccpt";
        $decode = JWT::decode($token, $jwt_secrect, array('HS256'));
        $returnData = [
            'success' => 1,
            "status"=> 200,
            'message' => 'Your Info.',
            "user"=> $decode->data,
        ]; 
    else: 
        $returnData = msg(0,401,'Unauthorized');
    endif;
    echo json_encode($returnData);

