<?php

class Event extends Model
{
    public function __construct()
    {
        $this->table = 'events';
        $this->getConnection();
    }

    public function create($data)
    {
        $sqlQuery = "INSERT INTO
                        " . $this->table . "
                    SET
                        title = :title, 
                        description = :description, 
                        max_participants = :max_participants";

        $stmt = $this->_connection->prepare($sqlQuery);

        $data->title = htmlspecialchars(strip_tags($data->title));
        $data->description = htmlspecialchars(strip_tags($data->description));
        $data->max_participants = htmlspecialchars(strip_tags($data->max_participants));

        $stmt->bindParam(":title", $data->title);
        $stmt->bindParam(":description", $data->description);
        $stmt->bindParam(":max_participants", $data->max_participants);

        if ($stmt->execute()) {
            return true;
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
                        " . $this->table . "
                    SET
                        title= :title, 
                        description= :description, 
                        max_participants= :max_participants
                    WHERE 
                        id = :id";

        $stmt = $this->_connection->prepare($sqlQuery);

        $data->title = htmlspecialchars(strip_tags($data->title));
        $data->description = htmlspecialchars(strip_tags($data->description));
        $data->max_participants = htmlspecialchars(strip_tags($data->max_participants));


        // bind data
        $stmt->bindParam(":title", $data->title);
        $stmt->bindParam(":description", $data->description);
        $stmt->bindParam(":max_participants", $data->max_participants);
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

    public function assignMaxApplicantsToEvent($data)
    {
        $sqlQuery = "UPDATE
                        " . $this->table . "
                    SET
                        max_participants= :max_participants
                    WHERE 
                        id = :id";

        $stmt = $this->_connection->prepare($sqlQuery);
        $data->max_participants = htmlspecialchars(strip_tags($data->max_participants));
        $data->id = htmlspecialchars(strip_tags($data->id));

        // bind data
        $stmt->bindParam(":max_participants", $data->max_participants);
        $stmt->bindParam(":id", $data->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}