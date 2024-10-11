<?php
require_once 'Database.php';

class indexController
{


    private $db;
    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function getFeedingTime() {
        
    }
}
