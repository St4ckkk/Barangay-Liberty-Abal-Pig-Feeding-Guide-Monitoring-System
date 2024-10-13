<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $feeding_id = $_POST['id'] ?? '';

    if (empty($feeding_id)) {
        $_SESSION['error'] = "Feeding period ID is required!";
    } else {
        $result = $settingsController->deleteFeedingPeriod($feeding_id);
        if ($result) {
            $_SESSION['success'] = 'Feeding period successfully deleted!';
        } else {
            $_SESSION['error'] = 'Failed to delete feeding period!';
        }
        header('Location: feedingPeriod.php');
        exit();
    }
}
