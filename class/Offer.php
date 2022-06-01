<?php

class Offer
{

    // Connection
    private $conn;

    // Table
    private $db_table = "offers";

    // Columns
    public $id;
    public $title;
    public $type;
    public $description;
    public $tags;
    public $requirements;


    // Db connection
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // GET ALL
    public function listOffers()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }


    // CREATE
    public function createOffer()
    {
        $sqlQuery = "INSERT INTO
                        " . $this->db_table . "
                    SET
                        title = :title, 
                        description = :description, 
                        requirements = :requirements, 
                        tags = :tags, 
                        type = :type";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->requirements = htmlspecialchars(strip_tags($this->requirements));
        $this->tags = htmlspecialchars(strip_tags($this->tags));
        $this->type = htmlspecialchars(strip_tags($this->type));


        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":requirements", $this->requirements);
        $stmt->bindParam(":tags", $this->tags);
        $stmt->bindParam(":type", $this->type);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // DELETE
    function deleteOffer()
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
    public function updateOffer()
    {
        $sqlQuery = "UPDATE
                        " . $this->db_table . "
                    SET
                        title= :title, 
                        description= :description, 
                        requirements= :requirements,
                        tags= :tags,
                        type= :type
                    WHERE 
                        id = :id";

        $stmt = $this->conn->prepare($sqlQuery);

        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->requirements = htmlspecialchars(strip_tags($this->requirements));
        $this->tags = htmlspecialchars(strip_tags($this->tags));
        $this->type = htmlspecialchars(strip_tags($this->type));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(":title", $this->title);
        $stmt->bindParam(":description", $this->description);
        $stmt->bindParam(":requirements", $this->requirements);
        $stmt->bindParam(":tags", $this->tags);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":id", $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}

?>

