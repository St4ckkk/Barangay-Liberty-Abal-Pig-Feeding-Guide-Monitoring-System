<?php
session_start();
require_once '../core/settingsController.php';

$settingsController = new settingsController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $frequency = $_POST['cleaningFrequency'] ?? '';
    $morningTime = $_POST['morningTime'] ?? null;
    $noonTime = $_POST['noonTime'] ?? null;
    $eveningTime = $_POST['eveningTime'] ?? null;

    if (empty($frequency)) {
        $_SESSION['error'] = "Cleaning frequency is required.";
        header('Location: cleaningPeriod.php');
        exit();
    }

    if ($frequency == 'once' && empty($morningTime)) {
        $_SESSION['error'] = "Morning cleaning time is required for once a day frequency.";
        header('Location: cleaningPeriod.php');
        exit();
    } elseif ($frequency == 'twice' && (empty($morningTime) || empty($eveningTime))) {
        $_SESSION['error'] = "Morning and evening cleaning times are required for twice a day frequency.";
        header('Location: cleaningPeriod.php');
        exit();
    } elseif (($frequency == 'thrice' || $frequency == 'custom') && (empty($morningTime) || empty($noonTime) || empty($eveningTime))) {
        $_SESSION['error'] = "All cleaning times are required for thrice a day or custom frequency.";
        header('Location: cleaningPeriod.php');
        exit();
    }

    $morningTime = filter_var($morningTime, FILTER_SANITIZE_SPECIAL_CHARS);
    $noonTime = filter_var($noonTime, FILTER_SANITIZE_SPECIAL_CHARS);
    $eveningTime = filter_var($eveningTime, FILTER_SANITIZE_SPECIAL_CHARS);

    try {
        $success = $settingsController->addCleaningPeriod($frequency, $morningTime, $noonTime, $eveningTime);

        if ($success) {
            $settingsController->sendNotification(
                "New Cleaning Schedule",
                "A new cleaning schedule has been added. Please check for details.",
                $success,
                "Cleaning"

            );
            $_SESSION['success'] = "Cleaning schedule added successfully.";
        } else {
            $_SESSION['error'] = "Error adding cleaning schedule.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    }

    header('Location: cleaningPeriod.php');
    exit();
} else {
    header('Location: cleaningPeriod.php');
    exit();
}