<?php
session_start();
require_once '../core/settingsController.php';

$settingsController = new settingsController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $frequency = $_POST['feedingFrequency'] ?? '';
    $morningTime = $_POST['morningTime'] ?? null;
    $noonTime = $_POST['noonTime'] ?? null;
    $eveningTime = $_POST['eveningTime'] ?? null;

    if (empty($frequency)) {
        $_SESSION['error'] = "Feeding time are required.";
        header('Location: feedingPeriod.php');
        exit();
    }

    if ($frequency == 'once' && empty($morningTime)) {
        $_SESSION['error'] = "Morning feeding time is required for once a day frequency.";
        header('Location: feedingPeriod.php');
        exit();
    } elseif ($frequency == 'twice' && (empty($morningTime) || empty($eveningTime))) {
        $_SESSION['error'] = "Morning and evening feeding times are required for twice a day frequency.";
        header('Location: feedingPeriod.php');
        exit();
    } elseif (($frequency == 'thrice' || $frequency == 'custom') && (empty($morningTime) || empty($noonTime) || empty($eveningTime))) {
        $_SESSION['error'] = "All feeding times are required for thrice a day or custom frequency.";
        header('Location: feedingPeriod.php');
        exit();
    }

    $morningTime = filter_var($morningTime, FILTER_SANITIZE_SPECIAL_CHARS);
    $noonTime = filter_var($noonTime, FILTER_SANITIZE_SPECIAL_CHARS);
    $eveningTime = filter_var($eveningTime, FILTER_SANITIZE_SPECIAL_CHARS);

    
    try {
        $feeding_id = $settingsController->addFeedingPeriod($frequency, $morningTime, $noonTime, $eveningTime);

        if ($feeding_id) {
            $settingsController->sendNotification(
                "New Feeding Schedule",     
                "A new Feeding schedule has been added. Please check for details.",
                $feeding_id,
                "Feeding Schedule",
            );
            $_SESSION['success'] = "Feeding schedule added successfully.";
        } else {
            $_SESSION['error'] = "Error adding feeding schedule.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    }

    header('Location: feedingPeriod.php');
    exit();
} else {
    header('Location: feedingPeriod.php');
    exit();
}
