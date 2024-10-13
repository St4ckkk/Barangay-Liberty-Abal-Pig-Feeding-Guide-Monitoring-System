<?php
session_start();
require_once '../core/settingsController.php';

$settingsController = new settingsController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedPigs = isset($_POST['selectedPigs']) ? explode(',', $_POST['selectedPigs']) : []; // Convert to array
    $penId = $_POST['penId'] ?? null;
    $slaughteringDate = $_POST['slaughteringDate'] ?? null;
    $slaughteringTime = $_POST['slaughteringTime'] ?? null;
    $status = 'process';
    if (empty($selectedPigs) || empty($penId) || empty($slaughteringDate) || empty($slaughteringTime)) {
        $_SESSION['error'] = "All fields are required!";
        header('Location: slaughteringPeriod.php');
        exit();
    } else {
        foreach ($selectedPigs as $pigId) {
            $result = $settingsController->addSlaughteringPeriod($penId, $pigId, $slaughteringDate, $slaughteringTime, $status);

            if (!$result) {
                $_SESSION['error'] = "Failed to add Slaughtering Period for pig ID: $pigId";
                break;
            }
        }

        if (!isset($_SESSION['error'])) {
            $_SESSION['success'] = 'Slaughtering Period and Schedule Successfully Added for selected pigs!';
            $settingsController->sendNotification(
                "New Slaughtering Schedule",
                "A new slaughtering schedule has been added. Please check for details.",
                $result,
                "slaughtering"
            );
        }

        header('Location: slaughteringPeriod.php');
        exit();
    }
} else {
    header('Location: slaughteringPeriod.php');
    exit();
}
