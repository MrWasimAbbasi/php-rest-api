<?php

class LearnerEvent
{

    // Connection
    private $conn;

    // Table
    private $db_table = "learner_events";

    // Columns
    public $id;
    public $learner_id;
    public $LearnerEvent_id;

    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function listLearnerEvents()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }


    // CREATE
    public function createLearnerEvent()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        learner_id = :learner_id, 
                        event_id= :event_id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->learner_id = htmlspecialchars(strip_tags($this->learner_id));
        $this->event_id = htmlspecialchars(strip_tags($this->event_id));


        $stmt->bindParam(":learner_id", $this->learner_id);
        $stmt->bindParam(":event_id", $this->event_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

?>

