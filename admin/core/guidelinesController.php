<?php

require_once 'Database.php';

class guidelinesController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }


    public function getCleaningGuidelines()
    {
        $query = "SELECT * FROM cleaning_guidelines ORDER BY importance DESC, category ASC";
        return $this->db->query($query)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addCleaningGuideline($title, $category, $description, $frequency, $importance, $equipment, $safety)
    {
        $query = "INSERT INTO cleaning_guidelines (title, category, description, frequency, importance, equipment, safety) 
                  VALUES (:title, :category, :description, :frequency, :importance, :equipment, :safety)";

        $params = [
            ':title' => $title,
            ':category' => $category,
            ':description' => $description,
            ':frequency' => $frequency,
            ':importance' => $importance,
            ':equipment' => $equipment,
            ':safety' => $safety
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function addHealthGuidelines($title, $description)
    {

        $query = "INSERT INTO healthguidelines (title, description) VALUES (:title, :description)";
        $params = [':title' => $title, ':description' => $description];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function getHealthGuidelines()
    {

        $query = "SELECT * FROM healthguidelines";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function addFeedingGuidelines($title, $pigStage, $weightRange, $feedType, $proteinContent, $feedingFrequency, $amountPerFeeding, $specialInstructions)
    {
        $query = "INSERT INTO feeding_guidelines (title, pig_stage, weight_range, feed_type, protein_content, feeding_frequency, amount_per_feeding, special_instructions) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $params = [$title, $pigStage, $weightRange, $feedType, $proteinContent, $feedingFrequency, $amountPerFeeding, $specialInstructions];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }


    public function getFeedingGuidelines()
    {

        $query = "SELECT * FROM feeding_guidelines";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function addPigs($pigType, $breed, $sex, $description)
    {
        $query = "INSERT INTO pigsguidelines (pigType, breed, sex, description) VALUES (:pigType, :breed, :sex, :description)";
        $params = [
            ':pigType' => $pigType,
            ':breed' => $breed,
            'sex' => $sex,
            ':description' => $description
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function getPigs()
    {

        $query = "SELECT * FROM pigsguidelines";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }



    public function updateFeedingGuidelines($guide_id, $title, $growthStage, $weightRange, $feedType, $proteinContent, $feedingFrequency, $amountFeeding, $specialInstructions)
    {
        $query = "UPDATE feeding_guidelines SET title = :title, pig_stage = :growthStage, weight_range = :weightRange, feed_type = :feedType, protein_content = :proteinContent, feeding_frequency = :feedingFrequency, amount_per_feeding = :amountFeeding, special_instructions = :specialInstructions WHERE guide_id = :guide_id";
        $params = [
            ':guide_id' => $guide_id,
            ':title' => $title,
            ':growthStage' => $growthStage,
            ':weightRange' => $weightRange,
            ':feedType' => $feedType,
            ':proteinContent' => $proteinContent,
            ':feedingFrequency' => $feedingFrequency,
            ':amountFeeding' => $amountFeeding,
            ':specialInstructions' => $specialInstructions,
        ];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }


    public function deleteFeedingGuidelines($guide_id)
    {
        $query = "DELETE FROM feeding_guidelines WHERE guide_id = :guide_id";
        $params = [':guide_id' => $guide_id];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function updateCleaningGuidelines($id, $title, $category, $description, $frequency, $importance, $equipment, $safety)
    {
        $query = "UPDATE cleaning_guidelines SET title = :title, category = :category, description = :description, frequency = :frequency, importance = :importance, equipment = :equipment, safety = :safety WHERE id = :id";
        $params = [
            ':id' => $id,
            ':title' => $title,
            ':category' => $category,
            ':description' => $description,
            ':frequency' => $frequency,
            ':importance' => $importance,
            ':equipment' => $equipment,
            ':safety' => $safety
        ];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    public function deleteCleaningGuidelines($id)
    {
        $query = "DELETE FROM cleaning_guidelines WHERE id = :id";
        $params = [':id' => $id];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }
}
