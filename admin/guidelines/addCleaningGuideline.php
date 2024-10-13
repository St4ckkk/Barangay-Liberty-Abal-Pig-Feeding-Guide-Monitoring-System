<?php
// File: addCleaningGuideline.php

require_once '../core/Database.php';
require_once '../core/guidelinesController.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'] ?? '';
    $category = $_POST['category'] ?? '';
    $description = $_POST['description'] ?? '';
    $frequency = $_POST['frequency'] ?? '';
    $importance = $_POST['importance'] ?? '';
    $equipment = $_POST['equipment'] ?? '';
    $safety = $_POST['safety'] ?? '';

    $cleaningGuidelinesController = new guidelinesController();

    $result = $cleaningGuidelinesController->addCleaningGuideline($title, $category, $description, $frequency, $importance, $equipment, $safety);

    if ($result) {
        $_SESSION['success'] = "Cleaning guideline added successfully.";
    } else {
        $_SESSION['error'] = "Error adding cleaning guideline. Please try again.";
    }
}

header('Location: disinfection-guidelines.php');
exit();
