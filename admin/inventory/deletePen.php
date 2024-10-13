<?php
require_once '../core/inventoryController.php';

$controller = new inventoryController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penId = $_POST['penId'] ?? null;

    if (empty($penId)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
    } else {
        // Attempt to delete the pen and check for pigs first
        if ($controller->deletePen($penId)) {
            $_SESSION['success'] = 'Feed deleted successfully.';
            header('Location: pen.php');
            exit();
        } else {
            // If the deletePen method returned false, set an appropriate error message
            $_SESSION['error'] = 'Failed to delete feed. ' . $_SESSION['error']; // Include specific error message
            header('Location: pen.php');
            exit();
        }
    }
}
