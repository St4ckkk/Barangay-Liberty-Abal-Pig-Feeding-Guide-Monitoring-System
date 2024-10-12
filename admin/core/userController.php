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

    public function createUsers($username, $password, $status, $role)
    {

        $query = "INSERT INTO useraccount (username, password, status, role) VALUES (:username, :password, :status, :role)";
        $params = [
            ':username' => $username,
            ':role' => $role,
            ':password' => $password,
            ':status' => $status
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);

        return $stmt;
    }


    public function getAllUsers() {

        $query = "SELECT * FROM useraccount";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
