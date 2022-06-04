<?php

class User extends Model
{
    public function __construct()
    {
        $this->table = 'users';
        $this->getConnection();
    }

    public function create($data)
    {
        $sqlQuery = "INSERT INTO
                        " . $this->table . "
                    SET
                        name = :name, 
                        email = :email, 
                        status = :status,  
                        created = :created";

        $stmt = $this->_connection->prepare($sqlQuery);

        // sanitize
        $data->name = htmlspecialchars(strip_tags($data->name));
        $data->email = htmlspecialchars(strip_tags($data->email));
        $data->status = htmlspecialchars(strip_tags($data->status));
        $data->created = date('Y-m-d');

        // bind data
        $stmt->bindParam(":name", $data->name);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":status", $data->status);
        $stmt->bindParam(":created", $data->created);

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

    // Black List
    public function blackListUser($id)
    {
        $sqlQuery = "UPDATE
                        " . $this->table . "
                    SET
                        status = :status 
                    WHERE 
                        id = :id";

        $stmt = $this->_connection->prepare($sqlQuery);

        $id = htmlspecialchars(strip_tags($id));
        $status = 'inactive';
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":status", $status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    //White List
    public function whiteListUser($id)
    {
        $sqlQuery = "UPDATE
                        " . $this->table . "
                    SET
                        status = :status 
                    WHERE 
                        id = :id";

        $stmt = $this->_connection->prepare($sqlQuery);

        $id = htmlspecialchars(strip_tags($id));
        $status = 'active';
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":status", $status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
