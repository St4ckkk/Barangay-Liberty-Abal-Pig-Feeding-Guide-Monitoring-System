<?php

require_once '../core/guidelinesController.php';

$controller = new guidelinesController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    


    if (empty($id)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
    }

    if (empty($_SESSION['error'])) {
        if ($controller->deleteCleaningGuidelines($id)) {
            $_SESSION['success'] = 'Cleaning guideline deleted successfully.';
            header('Location: disinfection-guidelines.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to delete cleaning guidelines.';
            header('Location: disinfection-guidelines.php');
            exit();
        }
    }
}
