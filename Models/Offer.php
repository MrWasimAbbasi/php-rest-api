<?php

class Offer extends Model
{
    public function __construct()
    {
        $this->table = 'offers';
        $this->getConnection();
    }

    public function create($data)
    {
        $sqlQuery = "INSERT INTO
                        " . $this->table . "
                    SET
                        title = :title, 
                        description = :description, 
                        requirements = :requirements, 
                        tags = :tags, 
                        type = :type";

        $stmt = $this->_connection->prepare($sqlQuery);

        $data->title = htmlspecialchars(strip_tags($data->title));
        $data->description = htmlspecialchars(strip_tags($data->description));
        $data->requirements = htmlspecialchars(strip_tags($data->requirements));
        $data->tags = htmlspecialchars(strip_tags($data->tags));
        $data->type = htmlspecialchars(strip_tags($data->type));


        $stmt->bindParam(":title", $data->title);
        $stmt->bindParam(":description", $data->description);
        $stmt->bindParam(":requirements", $data->requirements);
        $stmt->bindParam(":tags", $data->tags);
        $stmt->bindParam(":type", $data->type);

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
                        requirements= :requirements,
                        tags= :tags,
                        type= :type
                    WHERE 
                        id = :id";

        $stmt = $this->_connection->prepare($sqlQuery);

        $data->title = htmlspecialchars(strip_tags($data->title));
        $data->description = htmlspecialchars(strip_tags($data->description));
        $data->requirements = htmlspecialchars(strip_tags($data->requirements));
        $data->tags = htmlspecialchars(strip_tags($data->tags));
        $data->type = htmlspecialchars(strip_tags($data->type));

        // bind data
        $stmt->bindParam(":title", $data->title);
        $stmt->bindParam(":description", $data->description);
        $stmt->bindParam(":requirements", $data->requirements);
        $stmt->bindParam(":tags", $data->tags);
        $stmt->bindParam(":type", $data->type);
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
}

