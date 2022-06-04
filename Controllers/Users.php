<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, DELETE, GET ,PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


class Users extends Controller
{

    public function index()
    {
        $this->loadModel('User');
        $events = $this->User->getAll();
        echo json_encode($events);
    }

    public function create()
    {

        $this->loadModel('User');
        $data = json_decode(file_get_contents("php://input"));
        $acc = $this->User->create($data);
        if ($acc) {
            echo json_encode([http_response_code(200), 'success', $data]);
        } else {
            echo json_encode(['error' => 'offer not created']);
        }
    }

    public function update($id)
    {
        // die(var_dump($id));

        $this->loadModel('User');
        $data = json_decode(file_get_contents("php://input"));

        $acc = $this->User->update($data, $id);
        if ($acc) {
            echo json_encode('success');
        } else {
            echo json_encode('error');
        }
    }

    public function delete($id)
    {
        $this->loadModel('User');
        // $data = json_decode(file_get_contents("php://input"));
        $acc = $this->User->delete($id);
        if ($acc) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }


    public function find($id)
    {

        $this->LoadModel('User');
        $result = $this->User->find($id);

        if ($result) {
            echo json_encode(['success', $result]);
        } else {
            echo json_encode(['status', 'error']);
        }
    }

    public function blackListUser($id)
    {
        $this->LoadModel('User');
        $result = $this->User->blackListUser($id);

        if ($result) {
            echo json_encode(['success', $result]);
        } else {
            echo json_encode(['status', 'error']);
        }
    }
    public function whiteListUser($id)
    {
        $this->LoadModel('User');
        $result = $this->User->whiteListUser($id);

        if ($result) {
            echo json_encode(['success', $result]);
        } else {
            echo json_encode(['status', 'error']);
        }
    }
}