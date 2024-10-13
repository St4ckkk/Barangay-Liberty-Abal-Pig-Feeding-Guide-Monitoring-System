<?php

require_once '../core/guidelinesController.php';

$controller = new guidelinesController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? null;
    $category = $_POST['category'] ?? null;
    $description = $_POST['description'] ?? null;
    $frequency = $_POST['frequency'] ?? null;
    $importance = $_POST['importance'] ?? null;
    $equipment = $_POST['equipment'] ?? null;
    $safety = $_POST['safety'] ?? null;



    if (empty($id) || empty($title) || empty($category) || empty($description) || empty($frequency) || empty($importance) || empty($equipment) || empty($safety)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
    }

    if (empty($_SESSION['error'])) {
        if ($controller->updateCleaningGuidelines(
            $id,
            $title,
            $category,
            $description,
            $frequency,
            $importance,
            $equipment,
            $safety
        )) {
            $_SESSION['success'] = 'Cleaning guidelines updated successfully.';
            header('Location: disinfection-guidelines.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update cleaning guideline.';
            header('Location: disinfection-guidelines.php');
            exit();
        }
    }
}
