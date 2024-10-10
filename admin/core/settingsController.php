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

    public function addSchedForFeedingTime($penId = null, $schedTime, $schedType)
    {
        $query = "INSERT INTO schedule (penId, schedTime, schedType) VALUES (:penId, :schedTime, :schedType)";
        $params = [
            ':penId' => $penId,
            ':schedTime' => $schedTime,
            ':schedType' => $schedType
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
              JOIN pigpen pe ON p.penId = pe.penId";  // Assuming 'pen_id' is the foreign key in both tables

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }




    public function getFarrowingPeriods()
    {
        $query = "SELECT * FROM farrowing_monitoring";
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

    public function getFarrowing()
    {
        $query = "
        SELECT 
            sows.sow_id,
            pigpen.penno,
            pigs.ear_tag_number
        FROM 
            farrowing_monitoring
        JOIN 
            sows ON farrowing_monitoring.sow_id = sows.sow_id
        JOIN 
            pigs ON sows.pigId = pigs.pig_id
        JOIN 
            pigpen ON sows.penId = pigpen.penId
    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPigPens()
    {
        $query = "SELECT * FROM pigpen";
        $stmt  = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getFarrowingPigs($penId)
    {
        $query = "
        SELECT pigs.pig_id, pigs.ear_tag_number, pigs.breed 
        FROM pigs
        JOIN sows ON pigs.pig_id = sows.pigId
        WHERE pigs.penId = :penId 
        AND sows.status = 'Active'
    ";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':penId' => $penId]);
        return $stmt->fetchAll();
    }
}
