<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../../config/database.php';
include_once '../../Models/Offer.php';

$database = new Database();
$db = $database->getConnection();

$items = new Offer($db);

$stmt = $items->listOffers();
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
            "requirements" => $requirements,
            "type" => $type,
            "tags" => $tags
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