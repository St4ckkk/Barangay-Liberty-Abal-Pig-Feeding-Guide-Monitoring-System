<?php
require_once '../core/settingsController.php';

$settingsController = new settingsController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $slauId = $_POST['slauId'] ?? null;
    $slaughteringDate = $_POST['slaughteringDate'] ?? null;
    $slaughteringTime = $_POST['slaughteringTime'] ?? null;
    $status  = $_POST['status'] ?? null;

    if (empty($slauId) || empty($slaughteringDate) || empty($slaughteringTime) || empty($status)) {
        $_SESSION['error'] = "All fields are required!";
    } else {
        $result = $settingsController->updateSlaughteringPeriod($slauId, $status, $slaughteringDate, $slaughteringTime);
        if ($result) {
            $_SESSION['success'] = "Slaughtering period updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update slaughtering period";
        }
    }
    header('Location: slaughteringPeriod.php');
    exit();
}
