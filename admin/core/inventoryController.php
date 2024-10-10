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

    public function addFeedStocks($feedsName, $feedsDescription, $feedsCost, $QtyOFoodPerSack,)
    {
        $query = "INSERT INTO feedstock (feedsName, feedsDescription, feedsCost, QtyOFoodPerSack) VALUES (:feedsName, :feedsDescription,  :feedsCost, :QtyOFoodPerSack)";

        $params = [
            ':feedsName' => $feedsName,
            ':feedsDescription' => $feedsDescription,
            ':feedsCost' => $feedsCost,
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


    public function addExpense($expenseName, $expenseType, $total)
    {
        $query = "INSERT INTO expense (expenseName , expenseType, total) VALUES (:expenseName, :expenseType, :total)";

        $params = [
            ':expenseName' => $expenseName,
            ':expenseType' => $expenseType,
            ':total' => $total
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
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

    public function getPenCapacity($penId)
    {
        $query = "SELECT pigcount FROM pigpen WHERE penId = :penId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':penId' => $penId]);
        return $stmt->fetchColumn();
    }

    public function decreasePenCapacity($penId)
    {
        $query = "UPDATE pigpen SET pigcount = pigcount - 1 WHERE penId = :penId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':penId' => $penId]);
    }

    public function removePig($pigId, $penId)
    {
        $query = "DELETE FROM pigs WHERE pig_id = :pig_id";
        $stmt = $this->db->prepare($query);
        $result = $stmt->execute([':pig_id' => $pigId]);


        if ($result) {
            $this->increasePenCapacity($penId);
        }

        return $result;
    }

    public function getPenIdByPigId($pigId)
    {
        $query = "SELECT penId FROM pigs WHERE pig_id = :pig_id";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':pig_id' => $pigId]);
        return $stmt->fetchColumn();
    }


    public function increasePenCapacity($penId)
    {
        $query = "UPDATE pigpen SET pigcount = pigcount + 1 WHERE penId = :penId";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([':penId' => $penId]);
    }


    public function getFeedingSched()
    {
        $query = "SELECT * FROM schedule where schedType = 'Feeding'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateFeedingSched($penId, $schedId)
    {
        $query = "UPDATE schedule SET penId = :penId WHERE schedId = :schedId";
        $stmt = $this->db->prepare($query);

        return $stmt->execute([':penId' => $penId, ':schedId' => $schedId]);
    }
}
