<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cleaning_id = $_POST['id'] ?? '';

    if (empty($cleaning_id)) {
        $_SESSION['error'] = "Cleaning period ID is required!";
    } else {
        $result = $settingsController->deleteCleaningPeriod($cleaning_id);
        if ($result) {
            $_SESSION['success'] = 'Cleaning period successfully deleted!';
        } else {
            $_SESSION['error'] = 'Failed to Cleaning feeding period!';
        }
        header('Location: cleaningPeriod.php');
        exit();
    }
}
