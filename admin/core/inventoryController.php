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



    public function addPigs($etn, $penId, $status, $gender, $breed, $pigType, $weight, $age, $notes)
    {

        $checkQuery = "SELECT COUNT(*) FROM pigs WHERE ear_tag_number = :ear_tag_number";
        $checkStmt = $this->db->prepare($checkQuery);
        $checkStmt->execute([':ear_tag_number' => $etn]);
        $duplicateCount = $checkStmt->fetchColumn();

        if ($duplicateCount > 0) {
            return false;
        }

        $query = "INSERT INTO pigs (ear_tag_number, penId, status, gender, breed, pig_type, weight, age, notes) VALUES (:ear_tag_number, :penId, :status, :gender, :breed, :pig_type, :weight, :age, :notes)";
        $params = [
            ':ear_tag_number' => $etn,
            ':penId' => $penId,
            ':status' => $status,
            ':gender' => $gender,
            ':breed' => $breed,
            ':pig_type' => $pigType,
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
        AND status IN ('ready_for_breeding', 'in_breeding')
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

    public function getPenNoById($penId)
    {
        $query = 'SELECT penno FROM pigpen WHERE penId = :penId';
        $stmt = $this->db->prepare($query);
        $stmt->execute([':penId' => $penId]); // Correctly bind the parameter
        return $stmt->fetch(PDO::FETCH_ASSOC); // Fetch as associative array
    }

    public function getFeedstockData()
    {
        $query = 'SELECT feedsName, QtyOFoodPerSack FROM feedstock';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function updateFeedStocks($id, $feedsName, $feedsDescription, $feedsCost, $feed_purchase_date, $QtyOfFoodPerSack)
    {
        $query = "UPDATE feedstock SET feedsName = :feedsName, feedsDescription = :feedsDescription, feedsCost = :feedsCost, feed_purchase_date = :feed_purchase_date, QtyOFoodPerSack = :QtyOFoodPerSack WHERE id = :id";
        $params = [
            ':id' => $id,
            ':feedsName' => $feedsName,
            ':feedsDescription' => $feedsDescription,
            ':feedsCost' => $feedsCost,
            ':feed_purchase_date' => $feed_purchase_date,
            ':QtyOFoodPerSack' => $QtyOfFoodPerSack
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function deleteFeedStocks($id)
    {
        $query = "DELETE FROM feedstock WHERE id = :id";
        $params = [
            ':id' => $id
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function updatePen($penId, $penno, $penStatus, $pigCount)
    {
        $query = "UPDATE pigpen SET penno = :penno, penStatus = :penStatus, pigCount = :pigCount WHERE penId = :penId";
        $params = [
            ':penId' => $penId,
            ':penno' => $penno,
            ':penStatus' => $penStatus,
            ':pigCount' => $pigCount
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function deletePen($penId)
    {

        $stmt = $this->db->prepare("SELECT COUNT(*) FROM pigs WHERE penId = ?");
        $stmt->execute([$penId]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {

            $_SESSION['error'] = 'Cannot delete pen: there are pigs in this pen.';
            return false;
        }


        $stmt = $this->db->prepare("DELETE FROM pigpen WHERE penId = ?");
        return $stmt->execute([$penId]);
    }

    public function updatePig($pig_id, $ear_tag_number, $status, $gender, $breed, $pig_type, $weight, $age, $notes)
    {
        $query = "UPDATE pigs SET 
                    ear_tag_number = :ear_tag_number, 
                    status = :status, 
                    gender = :gender, 
                    breed = :breed, 
                    pig_type = :pig_type, 
                    weight = :weight, 
                    age = :age, 
                    notes = :notes, 
                    updated_at = NOW() 
                  WHERE pig_id = :pig_id";

        $params = [
            ':pig_id' => $pig_id,
            ':ear_tag_number' => $ear_tag_number,
            ':status' => $status,
            ':gender' => $gender,
            ':breed' => $breed,
            ':pig_type' => $pig_type,
            ':weight' => $weight,
            ':age' => $age,
            ':notes' => $notes
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
}
