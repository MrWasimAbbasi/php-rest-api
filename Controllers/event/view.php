<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../Models/Event.php';

$database = new Database();
$db = $database->getConnection();

$item = new Event($db);

$item->id = isset($_GET['id']) ? $_GET['id'] : die("Oh, pass id at least");

$item->getEvent();

if ($item->title != null) {
    // create array
    $event_arr = array(
        "id" => $item->id,
        "title" => $item->title,
        "description" => $item->description,
        "max_participants" => $item->max_participants,

    );

    http_response_code(200);
    echo json_encode($event_arr);
} else {
    http_response_code(404);
    echo json_encode("Event not found.");
}
?>