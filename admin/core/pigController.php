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
        $query = "
            SELECT pigs.*, breeds.name AS name 
            FROM pigs 
            JOIN breeds ON pigs.breed_id = breeds.id";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPigsByBreedID($breed_id)
    {
        $query = "
            SELECT pigs.*, breeds.name AS breed_name 
            FROM pigs 
            JOIN breeds ON pigs.breed_id = breeds.id 
            WHERE pigs.breed_id = :breed_id";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':breed_id', $breed_id);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getAllBreeds()
    {
        $query = "SELECT * FROM breeds";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function addPigs($ear_tag_number, $breed_id, $birth_date, $weight, $health_status, $pen_number, $gender)
    {
        $query = "INSERT INTO pigs (ear_tag_number, breed_id, birth_date, weight, health_status, pen_number, gender) VALUES (:ear_tag_number, :breed_id, :birth_date, :weight, :health_status, :pen_number, :gender)";
        $stmt = $this->db->prepare($query);
        $params = [
            ':ear_tag_number' => $ear_tag_number,
            ':breed_id' => $breed_id,
            ':birth_date' => $birth_date,
            ':weight' => $weight,
            ':health_status' => $health_status,
            ':pen_number' => $pen_number,
            ':gender' => $gender
        ];
        $stmt->execute($params);
        return $stmt->rowCount();
    }


    public function addBreeds($name, $description)
    {

        $query = "INSERT INTO breeds (name, description) VALUES (:name, :description)";
        $stmt = $this->db->prepare($query);
        $params = [
            ':name' => $name,
            ':description' => $description
        ];
        $stmt->execute($params);
        return $stmt->rowCount();
    }
}
