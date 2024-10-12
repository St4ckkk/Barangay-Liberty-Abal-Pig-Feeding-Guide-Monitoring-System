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


    public function sendNotification($title, $message, $refId)
    {
        try {

            $query = "SELECT userId FROM useraccount WHERE status = 'active' AND role = 'worker'";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $activeWorkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!empty($activeWorkers)) {
                $insertQuery = "INSERT INTO notifications (title, message, userId, refId) VALUES (:title, :message, :userId, :refId)";
                $stmtInsert = $this->db->prepare($insertQuery);

                foreach ($activeWorkers as $worker) {
                    $stmtInsert->execute([
                        ':title' => $title,
                        ':message' => $message,
                        ':userId' => $worker['userId'],
                        ':refId' => $refId
                    ]);
                }
                return true;
            }

            return false;
        } catch (Exception $e) {
            error_log('Error sending notification: ' . $e->getMessage());
            return false;
        }
    }
    
    public function addFeedingPeriod($feedingFrequency, $morningTime = null, $noonTime = null, $eveningTime = null): ?int
    {
        // Prepare the SQL query for inserting a feeding period
        $query = "INSERT INTO feeding_period (feeding_frequency, morning_feeding_time, noon_feeding_time, evening_feeding_time) VALUES (:frequency, :morning, :noon, :evening)";

        // Set up the parameters for the SQL statement
        $params = [
            ':frequency' => $feedingFrequency,
            ':morning' => $morningTime,
            ':noon' => $noonTime,
            ':evening' => $eveningTime,
        ];

        // Adjust parameters based on feeding frequency
        switch ($feedingFrequency) {
            case 'once':
                $params[':noon'] = null; // Set noon to null
                $params[':evening'] = null; // Set evening to null
                break;
            case 'twice':
                $params[':noon'] = null; // Set noon to null
                break;
            case 'thrice':
            case 'custom':
                break; // All parameters are already set
        }

        // Prepare and execute the SQL statement
        $stmt = $this->db->prepare($query);
        if ($stmt->execute($params)) {
            // Return the ID of the newly inserted feeding period
            return (int)$this->db->lastInsertId(); // Return as an integer
        }

        return null; // Return null if the insertion failed
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



    public function addCleaningPeriod($feedingFrequency, $morningTime = null, $noonTime = null, $eveningTime = null): bool
    {
        $query = "INSERT INTO cleaning_period (cleaning_frequency, morning_cleaning_time, noon_cleaning_time, evening_cleaning_time) VALUES (:frequency, :morning, :noon, :evening)";

        $params = [
            ':frequency' => $feedingFrequency,
            ':morning' => $morningTime,
            ':noon' => $noonTime,
            ':evening' => $eveningTime,
        ];
        switch ($feedingFrequency) {
            case 'once':
                $params[':noon'] = null;
                $params[':evening'] = null;
                break;
            case 'twice':
                $params[':noon'] = null;
                break;
            case 'thrice':
            case 'custom':
                break;
        }

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }


    public function addSlaughteringPeriod($penId, $pigId, $slaughtering_date, $slaughtering_time, $status)
    {
        $query = "INSERT INTO slaughtering_period (penId, pigId, slaughtering_date, slaughtering_time, status) VALUES (:penId, :pigId, :slaughtering_date, :slaughtering_time, :status)";

        $params = [
            ':penId' => $penId,
            ':pigId' => $pigId,
            ':slaughtering_date' => $slaughtering_date,
            ':slaughtering_time' => $slaughtering_time,
            ':status' => $status,
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function getCleaningPeriod()
    {
        $query = "SELECT * FROM cleaning_period";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function getFeedingPeriod()
    {
        $query = "SELECT * FROM feeding_period";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getSlaughteringPeriod()
    {
        $query = "SELECT s.*, p.ear_tag_number, p.breed, p.weight, p.age, pe.penno
              FROM slaughtering_period s
              JOIN pigs p ON s.pigId = p.pig_id
              JOIN pigpen pe ON p.penId = pe.penId";

        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getPigsByPen($penId)
    {

        $minAge = 5;
        $maxAge = 6;
        $minWeight = 91;
        $maxWeight = 136;
        $query = "SELECT * FROM pigs 
              WHERE penId = :penId 
              AND status = 'ready for slaughtering' 
              AND age >= :minAge 
              AND age <= :maxAge 
              AND weight >= :minWeight 
              AND weight <= :maxWeight";

        $params = [
            ':penId' => $penId,
            ':minAge' => $minAge,
            ':maxAge' => $maxAge,
            ':minWeight' => $minWeight,
            ':maxWeight' => $maxWeight
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }


    public function updateSlaughteringPeriod($slauId, $status, $slaughtering_date, $slaughtering_time,)
    {
        $query = "UPDATE slaughtering_period SET status = :status, slaughtering_date = :slaughtering_date, slaughtering_time = :slaughtering_time WHERE slauId = :slauId";
        $params = [
            ':status' => $status,
            ':slaughtering_date' => $slaughtering_date,
            ':slaughtering_time' => $slaughtering_time,
            ':slauId' => $slauId
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function deleteSlaughteringPeriod($slauId)
    {
        $query = "DELETE FROM slaughtering_period WHERE slauId = :slauId";
        $params = [':slauId' => $slauId];

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


    public function getFemaleDams($penId)
    {
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
