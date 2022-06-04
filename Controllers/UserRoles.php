<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, DELETE, GET ,PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


class UserRoles extends Controller
{

    public function index()
    {
        $this->loadModel('UserRole');
        $events = $this->UserRole->getAll();
        echo json_encode($events);
    }

    public function create()
    {

        $this->loadModel('UserRole');
        $data = json_decode(file_get_contents("php://input"));
        $acc = $this->UserRole->create($data);
        if ($acc) {
            echo json_encode([http_response_code(200), 'success', $data]);
        } else {
            echo json_encode(['error' => 'role not created']);
        }
    }

    public function update($id)
    {
        // die(var_dump($id));

        $this->loadModel('UserRole');
        $data = json_decode(file_get_contents("php://input"));

        $acc = $this->UserRole->update($data, $id);
        if ($acc) {
            echo json_encode('success');
        } else {
            echo json_encode('error');
        }
    }

    public function delete($id)
    {
        $this->loadModel('UserRole');
        // $data = json_decode(file_get_contents("php://input"));
        $acc = $this->UserRole->delete($id);
        if ($acc) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'error'));
        }
    }


    public function find($id)
    {

        $this->LoadModel('UserRole');
        $result = $this->UserRole->find($id);

        if ($result) {
            echo json_encode(['success', $result]);
        } else {
            echo json_encode(['status', 'error']);
        }
    }

    public function assignRole()
    {
        $this->loadModel('UserRole');
        $data = json_decode(file_get_contents("php://input"));
        $acc = $this->UserRole->assignRole($data);
        if ($acc) {
            echo json_encode([http_response_code(200), 'success']);
        } else {
            echo json_encode(['error' => 'role is not assigned']);
        }
    }
    public function revokeRole()
    {
        $this->loadModel('UserRole');
        $data = json_decode(file_get_contents("php://input"));
        $acc = $this->UserRole->revokeRole($data);
        if ($acc) {
            echo json_encode([http_response_code(200), 'success']);
        } else {
            echo json_encode(['error' => 'role is not revoked']);
        }
    }
}