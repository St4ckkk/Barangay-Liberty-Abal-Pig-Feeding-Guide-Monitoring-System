<?php

require_once 'Database.php';

class pigsController
{

    private $db;

    public function __construct()
    {

        $database = new Database();
        $this->db = $database->getConnection();
    }



    public function getAllPigs()
    {
        $query = "SELECT * FROM pigs";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll();
    }


    public function addPigs($ear_tag_number, $breed, $birth_date, $weight, $health_status, $pen_number, $gender)
    {
        $query = "INSERT INTO pigs (ear_tag_number, breed, birth_date, weight, health_status, pen_number, gender) VALUES (:ear_tag_number, :breed, :birth_date, :weight, :health_status, :pen_number, :gender)";
        $stmt = $this->db->prepare($query);
        $params = [
            ':ear_tag_number' => $ear_tag_number,
            ':breed' => $breed,
            ':birth_date' => $birth_date,
            ':weight' => $weight,
            ':health_status' => $health_status,
            ':pen_number' => $pen_number,
            ':gender' => $gender
        ];
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}
