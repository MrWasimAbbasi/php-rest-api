<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, DELETE, GET ,PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


class Events extends Controller
{

    public function index()
    {
        $this->loadModel('Event');
        $events = $this->Event->getAll();
        echo json_encode($events);
    }

    public function create()
    {

        $this->loadModel('Event');
        $data = json_decode(file_get_contents("php://input"));
        $acc = $this->Event->create($data);
        if ($acc) {
            echo json_encode([http_response_code(200), $data]);
        } else {
            echo json_encode(['error' => 'event not created']);
        }
    }

    public function update($id)
    {
        // die(var_dump($id));

        $this->loadModel('Event');
        $data = json_decode(file_get_contents("php://input"));

        $acc = $this->Event->update($data, $id);
        if ($acc) {
            echo json_encode('success');
        } else {
            echo json_encode('error');
        }
    }

    public function delete($id)
    {
        $this->loadModel('Event');
        // $data = json_decode(file_get_contents("php://input"));
        $acc = $this->Event->delete($id);
        if ($acc) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }


    public function find($id)
    {
        $this->LoadModel('Event');
        $result = $this->Event->find($id);

        if ($result) {
            echo json_encode(['success', $result]);
        } else {
            echo json_encode(['status', 'error', 'message' => 'Not found event']);
        }
    }
}