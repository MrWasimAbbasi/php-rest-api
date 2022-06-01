<?php

class UserRole
{

    // Connection
    private $conn;

    // Table
    private $db_table = "user_roles";

    // Columns
    public $id;
    public $user_id;
    public $role_id;
    public $status;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }


    // CREATE
    public function assignRole()
    {


        if (!$this->isRoleAlreadyExists()) {
            $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        user_id = :user_id, 
                        role_id = :role_id";

            $stmt = $this->conn->prepare($sqlQuery);

            // sanitize
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->role_id = htmlspecialchars(strip_tags($this->role_id));

            // bind data
            $stmt->bindParam(":user_id", $this->user_id);
            $stmt->bindParam(":role_id", $this->role_id);

            if ($stmt->execute()) {
                return true;
            }
        } else {
            return false;
        }
    }

    public function revokeRole()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE user_id = :user_id and role_id=:role_id";
        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":role_id", $this->role_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    // UPDATE
    public function isRoleAlreadyExists()
    {
        $sqlQuery = "SELECT
                        id, 
                        user_id, 
                        role_id
                      FROM
                        " . $this->db_table . "
                    WHERE 
                       user_id = :user_id
                       and
                       role_id = :role_id                       
                    LIMIT 0,1";


        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(':role_id', $this->role_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);


        if (!empty($dataRow)) {
            return true;
        } else {
            return false;
        }
    }

}

?>

