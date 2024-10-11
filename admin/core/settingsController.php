<?php

require_once 'Database.php';

class settingsController
{

    private $db;

    public function __construct()
    {

        $database = new Database();
        $this->db = $database->getConnection();
    }


    public function addSlaughteringSched($penId, $schedTime, $schedDate, $schedType)
    {
        $query = "INSERT INTO schedule (penId, schedTime, schedDate, schedType) VALUES (:penId, :schedTime, :schedDate, :schedType)";
        $params = [
            ':penId' => $penId,
            ':schedTime' => $schedTime,
            ':schedDate' => $schedDate,
            ':schedType' => $schedType
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function addSchedForFeedingTime($penId = null, $schedTime, $schedType, $status)
    {
        $query = "INSERT INTO schedule (penId, schedTime, schedType, status) VALUES (:penId, :schedTime, :schedType, :status)";
        $params = [
            ':penId' => $penId,
            ':schedTime' => $schedTime,
            ':schedType' => $schedType,
            ':status' => $status
        ];

        $stmt = $this->db->prepare($query);
        if ($stmt->execute($params)) {
            return $this->db->lastInsertId();
        }
        return false;
    }

    public function addFeedingTime($penId = null, $schedId, $feedsName)
    {
        $query = "INSERT INTO feeding (penId, schedId, feedsName) VALUES (:penId, :schedId, :feedsName)";
        $params = [
            ":penId" => $penId,
            ":schedId" => $schedId,
            "feedsName" => $feedsName
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }


    public function addSchedForCleaning($schedTime, $schedType)
    {
        $query = "INSERT INTO schedule (schedTime, schedType) VALUES (:schedTime, :schedType)";
        $params = [
            ':schedTime' => $schedTime,
            ':schedType' => $schedType
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }



    public function addSlaughteringPeriod($penId, $pigId, $slaughtering_date, $slaughtering_time)
    {
        $query = "INSERT INTO slaughter (penId, pigId, slaughtering_date, slaughtering_time) VALUES (:penId, :pigId, :slaughtering_date, :slaughtering_time)";

        $params = [
            ':penId' => $penId,
            ':pigId' => $pigId,
            ':slaughtering_date' => $slaughtering_date,
            ':slaughtering_time' => $slaughtering_time
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }



    public function getFeedingTime()
    {
        $query = "
            SELECT s.*, p.penno 
            FROM schedule s 
            JOIN pigpen p ON s.penId = p.penId 
            WHERE s.schedType = 'Feeding'
        ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getCleaningPeriod()
    {
        $query = "SELECT * FROM schedule WHERE schedType = 'Cleaning'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSlaughteringPeriod()
    {
        $query = "SELECT s.*, p.ear_tag_number, p.breed, p.weight, p.age, pe.penno
              FROM slaughter s
              JOIN pigs p ON s.pigId = p.pig_id
              JOIN pigpen pe ON p.penId = pe.penId";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPigsByPen($penId)
    {
        $query = "SELECT * FROM pigs WHERE penId = :penId AND status = 'ready for slaughter' AND health_status = 'healthy'";
        $params = [':penId' => $penId];
        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function updateSlaughteringPeriod($slauId, $status, $slaughtering_date, $slaughtering_time,)
    {
        $query = "UPDATE slaughter SET userStatus = :userStatus, slaughtering_date = :slaughtering_date, slaughtering_time = :slaughtering_time WHERE slauId = :slauId";
        $params = [
            ':userStatus' => $status,
            ':slaughtering_date' => $slaughtering_date,
            ':slaughtering_time' => $slaughtering_time,
            ':slauId' => $slauId
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
    public function getFarrowingPeriods()
    {
        $query = "
        SELECT 
            p.pig_id AS pig_id,
            p.ear_tag_number AS etn,
            p.status AS pig_status,
            f.breeding_date,
            f.expected_farrowing_date,
            f.actual_farrowing_date,
            f.sire,
            f.pregnancy_status,
            f.health_status,
            f.litter_size,
            p.penId,
            (SELECT penno FROM pigpen WHERE penId = p.penId) AS pen_number
        FROM 
            pigs p
        JOIN 
            farrowing f ON p.pig_id = f.pigId
        WHERE 
            p.status = 'ready for breeding'
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getFemaleDams($penId) {
        $query = "
        SELECT pigs.pig_id, pigs.ear_tag_number, pigs.breed 
        FROM pigs
        WHERE pigs.penId = :penId 
        AND pigs.gender = 'female' 
        AND pigs.status = 'ready for breeding'
        ";
    
        $stmt = $this->db->prepare($query);
        $stmt->execute([':penId' => $penId]);
        return $stmt->fetchAll();
    }
    

    public function getMaleSire()
    {
        $query = "
        SELECT pig_id, ear_tag_number, breed 
        FROM pigs
        WHERE gender = 'male' 
        AND status = 'ready for breeding'
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    




    public function getFeeds()
    {
        $query = "SELECT * FROM feedstock";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function updateSchedFeedingTime($penId, $schedTime, $status)
    {
        $query = "UPDATE schedule SET schedTime = :schedTime, status = :status WHERE penId = :penId";
        $params = [
            ':schedTime' => $schedTime,
            ':status' => $status,
            ':penId' => $penId
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    public function updateFeedingTime($penId, $schedId, $feedsName)
    {
        $query = "UPDATE feeding SET feedsName = :feedsName WHERE penId = :penId AND schedId = :schedId";
        $params = [
            ":penId" => $penId,
            ":schedId" => $schedId,
            ":feedsName" => $feedsName
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->rowCount() > 0;
    }

    public function getScheduleForPen($penId)
    {
        $query = "SELECT schedId FROM schedule WHERE penId = :penId";
        $params = [':penId' => $penId];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function addFarrowingPeriod($pigId, $penId, $breeding_date, $expected_farrowing_date, $sire, $pregnancy_status, $health_status, $litter_size, $notes)
    {
        $query = "INSERT INTO farrowing (pigId, penId, breeding_date, expected_farrowing_date, sire, pregnancy_status, health_status, litter_size, notes)
                  VALUES (:pigId, :penId, :breeding_date, :expected_farrowing_date, :sire, :pregnancy_status, :health_status, :litter_size, :notes)";
    
        $params = [
            ':pigId' => $pigId,
            ':penId' => $penId,
            ':breeding_date' => $breeding_date,
            ':expected_farrowing_date' => $expected_farrowing_date,
            ':sire' => $sire,
            ':pregnancy_status' => $pregnancy_status,
            ':health_status' => $health_status,
            ':litter_size' => $litter_size,
            ':notes' => $notes
        ];
    
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
    
}
