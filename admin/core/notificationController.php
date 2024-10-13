<?php

require_once 'Database.php';

class notificationController
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }


    public function getActiveNotifications($currentTime)
    {
        $query = "SELECT * FROM notifications 
                  WHERE schedTime <= :currentTime 
                  AND status = 'pending' 
                  ORDER BY schedTime ASC";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':currentTime', $currentTime);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getNotification()
    {
        $query = 'SELECT * FROM notifications';
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markNotificationAsDisplayed($notificationId)
    {
        $query = "UPDATE notifications 
                  SET status = 'displayed' 
                  WHERE id = :notificationId";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':notificationId', $notificationId);

        return $stmt->execute();
    }

    public function deleteOldNotifications($days = 30)
    {
        $cutoffDate = date('Y-m-d H:i:s', strtotime("-$days days"));
        $query = "DELETE FROM notifications 
                  WHERE schedTime < :cutoffDate 
                  AND status = 'displayed'";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cutoffDate', $cutoffDate);

        return $stmt->execute();
    }
    public function getNotificationById($id)
    {
        $sql = "SELECT n.*, f.feeding_frequency, f.morning_feeding_time, f.noon_feeding_time, f.evening_feeding_time
                FROM notifications n
                LEFT JOIN feeding_period f ON n.refId = f.feeding_id
                WHERE n.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getCleaningNotificationById($id)
    {
        $sql = "SELECT n.*, c.cleaning_frequency, c.morning_cleaning_time, c.noon_cleaning_time, c.evening_cleaning_time
                FROM notifications n
                LEFT JOIN cleaning_period c ON n.refId = c.cleaning_id
                WHERE n.id = :id";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getSlaughteringNotificationById($id)
    {
        $sql = "SELECT n.*, sp.slauId, p.penno, pg.ear_tag_number, 
                   sp.slaughtering_date, sp.slaughtering_time, 
                   sp.status, sp.created_at, sp.updated_at
            FROM notifications n
            LEFT JOIN slaughtering_period sp ON n.refId = sp.slauId  -- Join with slaughtering_period using refId
            LEFT JOIN pigpen p ON sp.penId = p.penId
            LEFT JOIN pigs pg ON sp.pigId = pg.pig_id
            WHERE n.id = :id"; // Fetch notification by its ID

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null; // Return null if no result found
    }
}
