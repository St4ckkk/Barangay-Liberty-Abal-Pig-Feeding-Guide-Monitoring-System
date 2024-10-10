<?php

require_once 'Database.php';

class inventoryController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function addFeedStocks($feedsName, $feedsDescription, $QtyOFoodPerSack,)
    {
        $query = "INSERT INTO feedstock (feedsName, feedsDescription, QtyOFoodPerSack) VALUES (:feedsName, :feedsDescription, :QtyOFoodPerSack)";
        $params = [
            ':feedsName' => $feedsName,
            ':feedsDescription' => $feedsDescription,
            ':QtyOFoodPerSack' => $QtyOFoodPerSack
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function getFeedStocks()
    {
        $query = "SELECT * FROM feedstock";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function addPigPens($penNo,  $penStatus, $pigCount)
    {
        $query = "INSERT INTO pigpen (penno, penstatus, pigcount) VALUES (:penno, :penstatus, :pigcount)";
        $params = [
            ':penno' => $penNo,
            ':penstatus' => $penStatus,
            ':pigcount' => $pigCount
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function getPigPens()
    {
        $query = "SELECT * FROM pigpen";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function addSows($sowId, $penId, $breed, $birthdate, $weight, $acquisitionDate, $status)
    {
        $query = "INSERT INTO sows (sow_id, penId, breed, birth_date, weight_kg, acquisition_date, status) VALUES (:sow_id, :penId, :breed, :birth_date, :weight_kg, :acquisition_date, :status)";
        $params = [
            ':sow_id' => $sowId,
            ':penId' => $penId,
            ':breed' => $breed,
            ':birth_date' => $birthdate,
            ':weight_kg' => $weight,
            ':acquisition_date' => $acquisitionDate,
            ':status' => $status
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
    public function getSows()
    {
        $query = "
            SELECT sows.*, pigpen.penno 
            FROM sows 
            JOIN pigpen ON sows.penId = pigpen.penId
        ";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPigs($penId)
    {

        $query = "
        SELECT pigs.*, pigpen.penno 
        FROM pigs 
        JOIN pigpen ON pigs.penId = pigpen.penId 
        WHERE pigs.penId = :penId
    ";
        $params = [':penId' => $penId];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if (!empty($result)) {
            return $result;
        }
        return null;
    }

    public function getPenno($penId)
    {
        $query = "
        SELECT penno 
        FROM pigpen 
        WHERE penId = :penId
    ";
        $params = [':penId' => $penId];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return !empty($result) ? $result['penno'] : null;
    }



    public function addPigs($etn, $penId,  $status, $gender, $healthStatus, $breed, $acquisition_date, $weight, $age, $notes)
    {
        $query = "INSERT INTO pigs (ear_tag_number, penId,  status, gender, health_status, breed, acquisition_date, weight, age, notes) VALUES (:ear_tag_number, :penId, :status , :gender, :health_status, :breed, :acquisition_date, :weight, :age, :notes)";
        $params = [
            ':ear_tag_number' => $etn,
            ':penId' => $penId,
            ':status' => $status,
            ':gender' => $gender,
            ':health_status' => $healthStatus,
            ':breed' => $breed,
            ':acquisition_date' => $acquisition_date,
            ':weight' => $weight,
            ':age' => $age,
            ':notes' => $notes
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
}
