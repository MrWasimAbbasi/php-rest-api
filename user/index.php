<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../Models/User.php';

$database = new Database();
$db = $database->getConnection();

$items = new User($db);

$stmt = $items->getUser();
$itemCount = $stmt->rowCount();



if ($itemCount > 0) {

    $userArr = array();
    $userArr["data"] = array();
    $userArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "name" => $name,
            "email" => $email,
            "status" => $status,
            "created" => $created
        );

        array_push($userArr["data"], $e);
    }
    echo json_encode($userArr);
} else {
    echo json_encode(
        ["message" => "No record found."]
    );
}
?>