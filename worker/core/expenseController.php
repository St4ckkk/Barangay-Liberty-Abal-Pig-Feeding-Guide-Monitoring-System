<?php

include_once 'Database.php';

class expenseController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    function getAllExpenses() {
        $query = "SELECT * FROM expense";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}