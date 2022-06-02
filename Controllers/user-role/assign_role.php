<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../Models/UserRole.php';

$database = new Database();
$db = $database->getConnection();

$item = new UserRole($db);

$data = json_decode(file_get_contents("php://input"));

// User values
$item->role_id = $data->role_id;
$item->user_id = $data->user_id;

if ($item->assignRole()) {
    echo json_encode("Role is assigned to user.");
} else {
    echo json_encode("Role already assigned to user");
}
?>