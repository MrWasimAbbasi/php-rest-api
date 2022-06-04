<?php

class UserRole extends Model
{
    public function __construct()
    {
        $this->table = 'user_roles';
        $this->getConnection();
    }

    // CREATE
    public function assignRole($data)
    {
        if (!$this->isRoleAlreadyExists($data)) {
            $sqlQuery = "INSERT INTO
                        " . $this->table . "
                    SET
                        user_id = :user_id, 
                        role_id = :role_id";

            $stmt = $this->_connection->prepare($sqlQuery);

            // sanitize
            $data->user_id = htmlspecialchars(strip_tags($data->user_id));
            $data->role_id = htmlspecialchars(strip_tags($data->role_id));

            // bind data
            $stmt->bindParam(":user_id", $data->user_id);
            $stmt->bindParam(":role_id", $data->role_id);

            if ($stmt->execute()) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function revokeRole($data)
    {
        $sqlQuery = "DELETE FROM " . $this->table . " WHERE user_id = :user_id and role_id=:role_id";
        $stmt = $this->_connection->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":user_id", $data->user_id);
        $stmt->bindParam(":role_id", $data->role_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    // UPDATE
    public function isRoleAlreadyExists($data)
    {
        $sqlQuery = "SELECT
                        id, 
                        user_id, 
                        role_id
                      FROM
                        " . $this->table . "
                    WHERE 
                       user_id = :user_id
                       and
                       role_id = :role_id                       
                    LIMIT 0,1";


        $stmt = $this->_connection->prepare($sqlQuery);

        $stmt->bindParam(':role_id', $data->role_id);
        $stmt->bindParam(':user_id', $data->user_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!empty($dataRow)) {
            return true;
        } else {
            return false;
        }
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
}