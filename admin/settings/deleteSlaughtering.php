<?php


require_once '../core/settingsController.php';

$settingsController = new settingsController();

// Check if slauId is set in the URL
if (isset($_GET['slauId'])) {
    $slauId = $_GET['slauId'];

    // Call the delete method
    $result = $settingsController->deleteSlaughteringPeriod($slauId);
    if ($result) {
        $_SESSION['success'] = "Slaughtering period deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete slaughtering period";
    }

    // Redirect to the slaughtering period page
    header('Location: slaughteringPeriod.php');
    exit();
} else {
    // Handle case when slauId is not provided
    $_SESSION['error'] = "Slaughtering ID not specified.";
    header('Location: slaughteringPeriod.php');
    exit();
}
