<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../../config/database.php';
include_once '../../Models/LearnerEvent.php';

$database = new Database();
$db = $database->getConnection();

$item = new LearnerEvent($db);

$data = json_decode(file_get_contents("php://input"));

$item->learner_id = $data->learner_id;
$learner_id = $data->learner_id;
$item->event_id = $data->event_id;
$event_id = $data->event_id;

// User values

if ($item->createLearnerEvent()) {
    echo json_encode("Learner with id $learner_id has joined event $event_id .");
} else {
    echo json_encode("Something went wrong");
}
?>