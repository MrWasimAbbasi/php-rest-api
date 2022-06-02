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
    public $event_id;

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


    //Count
    public function getEventApplicants()
    {
        $sqlQuery = "SELECT count(*) as total FROM " . $this->db_table . " where event_id=:event_id";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(":event_id", $this->event_id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            return $row->total;
        } else {
            return 0;
        }
    }

    // CREATE
    public function createLearnerEvent()
    {
        $total_applicants = $this->getEventApplicants();
        $allowed_applicant = $this->getEventMaxApplicants();
        if ($total_applicants <= $allowed_applicant) {
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
        } else {
            echo "Limit reached, maximum $allowed_applicant applicants allowed";
            die;
        }
        return false;
    }

    private function getEventMaxApplicants()
    {
        $sqlQuery = "SELECT * FROM events where id=" . $this->event_id;
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_OBJ);
        if (!empty($row)) {
            return $row->max_participants;
        } else {
            return 0;
        }

    }
}

?>

