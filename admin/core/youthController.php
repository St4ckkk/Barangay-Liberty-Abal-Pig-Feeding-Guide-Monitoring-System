<?php
require_once 'Database.php';

class youthController
{

    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getBarangay()
    {
        $query = "SELECT * FROM barangays";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getBarangayByID($barangay_id)
    {
        $query = "SELECT * FROM barangays WHERE id = :barangay_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }


    public function getYouthCountByBarangay()
    {
        $query = "
            SELECT b.id, b.name, COUNT(sr.response_id) AS youth_count
            FROM barangays b
            LEFT JOIN survey_responses sr ON b.id = sr.barangay_id
            GROUP BY b.id, b.name
        ";

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllYouthProfiles($barangay_id)
    {
        $query = "
        SELECT sr.*, b.name as barangay_name
        FROM survey_responses sr
        INNER JOIN barangays b ON sr.barangay_id = b.id
        WHERE sr.barangay_id = :barangay_id
    ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':barangay_id', $barangay_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getYouthProfileByID($youthId)
    {
        $query = "SELECT * FROM survey_responses WHERE response_id = :response_id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':response_id', $youthId, PDO::PARAM_INT);
        $stmt->execute();
        $youthProfile = $stmt->fetch(PDO::FETCH_ASSOC);
        return $youthProfile ?: [];

    }
}
