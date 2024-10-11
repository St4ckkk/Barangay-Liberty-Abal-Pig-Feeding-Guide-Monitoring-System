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

    public function addNotification($penId, $schedId, $message, $schedTime)
    {
        $query = "INSERT INTO notifications (penId, schedId, message, schedTime, status) 
                  VALUES (:penId, :schedId, :message, :schedTime, 'pending')";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':penId', $penId);
        $stmt->bindParam(':schedId', $schedId);
        $stmt->bindParam(':message', $message);
        $stmt->bindParam(':schedTime', $schedTime);

        return $stmt->execute();
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
}
