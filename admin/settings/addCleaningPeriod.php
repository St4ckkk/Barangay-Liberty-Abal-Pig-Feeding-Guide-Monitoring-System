<?php
// session_start(); 
require_once '../core/settingsController.php';

$settingsController = new settingsController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedTime = $_POST['schedTime'] ?? null;

    if (empty($schedTime)) {
        $error = "All fields are required!";
    } else {
        $schedType = 'Cleaning';
        $result = $settingsController->addSched($schedTime, $schedType);

        if ($result) {
            $_SESSION['success'] = 'Cleaning Period Successfully Added!';
        } else {
            $_SESSION['error'] = "Failed to add Cleaning Period";
        }
        header('Location: cleaningPeriod.php');
        exit();
    }
}
