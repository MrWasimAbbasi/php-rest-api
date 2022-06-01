<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/User.php';

$database = new Database();
$db = $database->getConnection();

$items = new User($db);

$stmt = $items->getUser();
$itemCount = $stmt->rowCount();



if ($itemCount > 0) {

    $employeeArr = array();
    $employeeArr["body"] = array();
    $employeeArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "status" => $status,
            "created" => $created
        );

        array_push($employeeArr["body"], $e);
    }
    echo json_encode($employeeArr);
} else {
    echo json_encode(
        ["message" => "No record found."]
    );
}
?>