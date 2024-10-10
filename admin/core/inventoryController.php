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

    public function addFeedStocks($feedsName, $feedsDescription, $feedsCost, $purchasedDate, $QtyOFoodPerSack)
    {
        $query = "INSERT INTO feedstock (feedsName, feedsDescription, feedsCost, feed_purchase_date, QtyOFoodPerSack) VALUES (:feedsName, :feedsDescription,  :feedsCost, :feed_purchase_date, :QtyOFoodPerSack)";

        $params = [
            ':feedsName' => $feedsName,
            ':feedsDescription' => $feedsDescription,
            ':feedsCost' => $feedsCost,
            ':feed_purchase_date' => $purchasedDate,
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


    public function addExpense($expenseName, $expenseType, $total, $expenseDate)
    {
        $query = "INSERT INTO expense (expenseName , expenseType, total, expenseDate) VALUES (:expenseName, :expenseType, :total, :expenseDate)";

        $params = [
            ':expenseName' => $expenseName,
            ':expenseType' => $expenseType,
            ':total' => $total,
            ':expenseDate' => $expenseDate
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


    public function addSows($penId, $pigs, $status)
    {
        $query = "INSERT INTO sows (penId, pigId, status) VALUES (:penId, :pigId, :status)";
        $params = [
            ':penId' => $penId,
            ':pigId' => $pigs,
            ':status' => $status
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
    public function getSows()
    {
        $query = "
        SELECT sows.*, pigpen.penno, pigs.ear_tag_number, pigs.weight, pigs.acquisition_date, pigs.age, pigs.breed
        FROM sows
        JOIN pigpen ON sows.penId = pigpen.penId
        JOIN pigs ON sows.pigId = pigs.pig_id
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

    public function getPigsByPen($penId)
    {
        $query = "
        SELECT pig_id, ear_tag_number, breed 
        FROM pigs 
        WHERE penId = :penId 
        AND gender = 'female' 
        AND status IN ('ready for breeding', 'in breeding')
        AND health_status = 'healthy'
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':penId' => $penId]);
        return $stmt->fetchAll();
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
