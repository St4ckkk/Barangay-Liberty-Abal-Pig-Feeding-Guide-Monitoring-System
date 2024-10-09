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

    public function addFeedingTime($schedTime, $schedType)
    {
        $query = "INSERT INTO schedule (schedTime, schedType) VALUES (:schedTime, :schedType)";
        $params = [
            ':schedTime' => $schedTime,
            ':schedType' => $schedType
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
    }


    public function getFeedingTime()
    {
        $query = "SELECT * FROM schedule WHERE schedType = 'Feeding'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
