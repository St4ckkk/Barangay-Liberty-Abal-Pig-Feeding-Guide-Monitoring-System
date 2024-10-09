<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();
session_start(); 
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedTime = $_POST['schedTime'] ?? null;

    if (empty($schedTime)) {
        $error = "All fields are required!";
    } else {
        $schedType = 'Feeding';
        $result = $settingsController->addFeedingTime($schedTime, $schedType);

        if ($result) {
            $_SESSION['success'] = 'Feeding Time Successfully Added!';
        } else {
            $_SESSION['error'] = "Failed to add Feeding Time";
        }
        header('Location: feedingTime.php');
        exit();
    }
}
