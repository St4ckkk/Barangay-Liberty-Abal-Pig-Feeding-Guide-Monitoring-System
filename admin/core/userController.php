<?php

include_once 'Database.php';

class userController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function createUsers($username, $password, $status)
    {

        $query = "INSERT INTO users (username, password, status) VALUES (:username, :password, :status)";
        $params = [
            ':username' => $username,
            ':password' => $password,
            ':status' => $status
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }


    public function getAllUsers() {

        $query = "SELECT * FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
