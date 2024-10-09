<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $schedTime = $_POST['schedTime'] ?? null;

    if (empty($schedTime)) {
        $error = "All fields are required!";
    } else {
        if (empty($schedType)) {
            $schedType = 'Feeding';
        }

        if (!$error) {
            $result = $settingsController->addFeedingTime($schedTime, $schedType);
            if ($result) {
                $success = 'Feeding Time Successfully Added!';
                header('Location: feedingTime.php');
                exit();
            } else {
                $error = "Failed to add User";
            }
        }
    }
}
