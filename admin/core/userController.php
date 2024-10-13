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


    public function getAllUsers()
    {

        $query = "SELECT * FROM useraccount";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }


    public function editUser($userId, $username, $role, $status)
    {
        $query = "UPDATE useraccount SET username = :username, role = :role, status = :status WHERE userId = :userId";
        $params = [
            ':username' => $username,
            ':role' => $role,
            ':status' => $status,
            ':userId' => $userId
        ];

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }


    public function deleteUser($userId)
    {

        $deleteNotificationsQuery = "DELETE FROM notifications WHERE userId = :userId";
        $deleteStmt = $this->db->prepare($deleteNotificationsQuery);
        $deleteStmt->execute([':userId' => $userId]);

        $query = "DELETE FROM useraccount WHERE userId = :userId";
        $stmt = $this->db->prepare($query);
        $stmt->execute([':userId' => $userId]);

        return $stmt;
    }
}
