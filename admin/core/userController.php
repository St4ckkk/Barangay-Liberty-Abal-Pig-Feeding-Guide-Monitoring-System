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

    public function createSecretaryAccount($name, $username, $email, $password, $role, $position, $status)
    {

        $query = "INSERT INTO sk_members(name, username, email, password, role, position, status) VALUES (:name, :username, :email, :password, :role, :position, :status)";
        $stmt = $this->db->prepare($query);
        $params = [
            ':name' => $name,
            ':username' => $username,
            ':email' => $email,
            ':password' => $password,
            ':role' => $role,
            ':position' => $position,
            ':status' => $status
        ];
        $stmt->execute($params);
        return $stmt->rowCount();
    }


    public function updateSecretaryAccount($id, $name, $username, $email)
    {
        $query = "UPDATE sk_members SET name = :name, username = :username, email = :email WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $params = [
            ':id' => $id,
            ':name' => $name,
            ':email' => $email,
            ':username' => $username
        ];
        $stmt->execute($params);
        return $stmt->rowCount();
    }

    public function deleteSecretaryAccount($id)
    {
        $query = "DELETE FROM sk_members WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $params = [':id' => $id];
        $stmt->execute($params);
        return $stmt->rowCount();
    }


    public function getSecretaryUsers()
    {
        $query = "SELECT * FROM sk_members WHERE role = 'secretary'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
