<?php

class Event
{

    // Connection
    private $conn;

    // Table
    private $db_table = "events";

    // Columns
    public $id;
    public $title;
    public $description;
    public $max_participants;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function listEvents()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }


    // CREATE
    public function createEvent()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        title = :title, 
                        description = :description, 
                        max_participants = :max_participants";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->max_participants = htmlspecialchars(strip_tags($this->max_participants));


        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":max_participants", $this->max_participants);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteEvent()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->id = htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // UPDATE
    public function updateEvent()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        title= :title, 
                        description= :description, 
                        max_participants= :max_participants
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->max_participants = htmlspecialchars(strip_tags($this->max_participants));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":max_participants", $this->max_participants);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    // UPDATE
    public function assignMaxApplicantsToEvent()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        max_participants= :max_participants
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);
        $this->max_participants = htmlspecialchars(strip_tags($this->max_participants));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":max_participants", $this->max_participants);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getEvent()
    {
        $sqlQuery = "SELECT
        *
        FROM
        " . $this->db_table . "
        WHERE 
        id = ?
        LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);

        $stmt->bindParam(1, $this->id);

        $stmt->execute();

        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($dataRow)) {
            $this->id = $dataRow['id'];
            $this->title = $dataRow['title'];
            $this->description = $dataRow['description'];
            $this->max_participants = $dataRow['max_participants'];
        } else {
            return null;
        }
    }

}

?>

