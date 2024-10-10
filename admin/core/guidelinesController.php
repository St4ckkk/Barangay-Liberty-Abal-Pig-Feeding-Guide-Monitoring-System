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


    public function addDisinfectionGuidelines($title, $description)
    {

        $query = "INSERT INTO disinfectionguidelines (title, description) VALUES (:title, :description)";
        $params = [':title' => $title, ':description' => $description];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }


    public function getDisinfectionGuidelines()
    {

        $query = "SELECT * FROM disinfectionguidelines";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
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


    public function addFeedingGuidelines($title, $description)
    {

        $query = "INSERT INTO feedingguidelines (title, description) VALUES (:title, :description)";
        $params = [':title' => $title, ':description' => $description];
        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }


    public function getFeedingGuidelines()
    {

        $query = "SELECT * FROM feedingguidelines";
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
}
