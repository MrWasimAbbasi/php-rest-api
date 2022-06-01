<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../class/Event.php';

$database = new Database();
$db = $database->getConnection();

$items = new Event($db);

$stmt = $items->listEvents();
$itemCount = $stmt->rowCount();


if ($itemCount > 0) {

    $eventArr = array();
    $eventArr["body"] = array();
    $eventArr["itemCount"] = $itemCount;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $e = array(
            "id" => $id,
            "title" => $title,
            "description" => $description,
            "max_participants" => $max_participants,
        );

        array_push($eventArr["body"], $e);
    }
    echo json_encode($eventArr);
} else {
    echo json_encode(
        ["message" => "No record found."]
    );
}
?>