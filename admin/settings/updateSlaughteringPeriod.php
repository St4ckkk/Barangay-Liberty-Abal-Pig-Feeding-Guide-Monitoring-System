<?php
require_once '../core/settingsController.php';

$settingsController = new settingsController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedPigs = isset($_POST['selectedPigs']) ? explode(',', $_POST['selectedPigs']) : []; // Convert to array
    $slauId = $_POST['slauId'] ?? null;
    $slaughteringDate = $_POST['slaughteringDate'] ?? null;
    $slaughteringTime = $_POST['slaughteringTime'] ?? null;
    $status  = $_POST['status'] ?? null;

    if (empty($slauId) || empty($slaughteringDate) || empty($slaughteringTime) || empty($status)) {
        $_SESSION['error'] = "All fields are required!";
    } else {
        $result = $settingsController->updateSlaughteringPeriod($slauId, $status, $slaughteringDate, $slaughteringTime);

        if ($result) {
            // Prepare notification details
            $title = "Slaughtering Schedule Update";
            $message = "The slaughtering schedule has been updated to: Date - $slaughteringDate, Time - $slaughteringTime.";
            $refId = $slauId;  // Assuming slaughtering ID is used as a reference ID
            $actionType = "Slaughtering Schedule";  // You can define action types like 'create', 'update', etc.
            $isUpdate = true;  // Since this is an update operation

            // Send notification
            $notificationResult = $settingsController->sendNotification($title, $message, $refId, $actionType, $isUpdate);

            if ($notificationResult) {
                $_SESSION['success'] = "Slaughtering period updated and notifications sent successfully!";
            } else {
                $_SESSION['error'] = "Slaughtering period updated, but failed to send notifications.";
            }
        } else {
            $_SESSION['error'] = "Failed to update slaughtering period.";
        }
    }
    header('Location: slaughteringPeriod.php');
    exit();
}
