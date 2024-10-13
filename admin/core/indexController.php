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

    public function getTotalPigs()
    {
        $query = 'SELECT COUNT(*) as total_pigs FROM pigs';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return $result['total_pigs'];
    }


    public function getTotalPen()
    {
        $query = 'SELECT COUNT(*) as total_pen FROM pigpen';

        $stmt = $this->db->prepare($query);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);


        return $result['total_pen'];
    }

    public function getPreviousTotalPigs()
    {
        // Example query for the previous day (modify based on your data structure)
        // Assuming there's a column `created_at` to track when the pig record was added
        $query = "SELECT COUNT(*) AS total FROM pigs WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 DAY)";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }
    public function calculatePercentageChange($currentTotal, $previousTotal)
    {
        if ($previousTotal == 0) {
            return 100; 
        }
        return (($currentTotal - $previousTotal) / $previousTotal) * 100;
    }
}
