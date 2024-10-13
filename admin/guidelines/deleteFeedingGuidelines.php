<?php

require_once '../core/guidelinesController.php';

$controller = new guidelinesController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guide_id = $_POST['guide_id'] ?? null;
    


    if (empty($guide_id)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
    }

    if (empty($_SESSION['error'])) {
        if ($controller->deleteFeedingGuidelines($guide_id)) {
            $_SESSION['success'] = 'Feeding guideline deleted successfully.';
            header('Location: feeding-guidelines.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to delete feeding guideline.';
            header('Location: feeding-guidelines.php');
            exit();
        }
    }
}
