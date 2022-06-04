<?php

class LearnerEvent extends Model
{
    public function __construct()
    {
        $this->table = 'learner_events';
        $this->getConnection();
    }

    public function create($data)
    {
        $total_applicants = $this->getEventApplicants();
        $allowed_applicant = $this->getEventMaxApplicants($data->event_id);
        if ($total_applicants <= $allowed_applicant) {
            $sqlQuery = "INSERT INTO
                        " . $this->table . "
                    SET
                        learner_id = :learner_id, 
                        event_id= :event_id";

            $stmt = $this->_connection->prepare($sqlQuery);

            $data->learner_id = htmlspecialchars(strip_tags($data->learner_id));
            $data->event_id = htmlspecialchars(strip_tags($data->event_id));


            $stmt->bindParam(":learner_id", $data->learner_id);
            $stmt->bindParam(":event_id", $data->event_id);

            if ($stmt->execute()) {
                return true;
            }
        }
        return false;
    }

    public function find($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE `id`='" . $id . "'";
        $query = $this->_connection->prepare($sql);

        if ($query->execute()) {
            return $query->fetch(PDO::FETCH_ASSOC);
        } else {
            return false;
        }


    }

    public function update($data, $id)
    {

        $sqlQuery = "UPDATE
                        " . $this->_connection . "
                    SET
                        name = :name, 
                        email = :email, 
                        status = :status,  
                        created = :created
                    WHERE 
                        id = :id";

        $stmt = $this->_connection->prepare($sqlQuery);

        $data->name = htmlspecialchars(strip_tags($data->name));
        $data->email = htmlspecialchars(strip_tags($data->email));
        $data->status = htmlspecialchars(strip_tags($data->status));
        $data->created = htmlspecialchars(strip_tags($data->created));

        // bind data
        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":status", $data->status);
        $stmt->bindParam(":created", $data->created);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id)
    {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->_connection->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    // GET ALL
    public function index()
    {
        $sqlQuery = "SELECT * FROM " . $this->table . "";
        $stmt = $this->_connection->prepare($sqlQuery);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }

    public function getEventApplicants()
    {
        $sqlQuery = "SELECT count(*) as total FROM " . $this->table . " where event_id=:event_id";
        $stmt = $this->_connection->prepare($sqlQuery);
        $stmt->bindParam(":event_id", $this->event_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            return $row->total;
        } else {
            return 0;
        }
    }

    public function getEventMaxApplicants($event_id)
    {
        $sqlQuery = "SELECT * FROM events where id=" . $event_id;
        $stmt = $this->_connection->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            return $row->max_participants;
        } else {
            return 0;
        }

    }

}

