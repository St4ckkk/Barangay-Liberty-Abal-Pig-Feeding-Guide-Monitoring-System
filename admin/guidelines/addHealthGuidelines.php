<?php
session_start();
require_once '../core/guidelinesController.php';

$guideline = new guidelinesController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $title = $_POST['title'] ?? null;
    $description = $_POST['description'] ?? null;

    if (empty($title) || empty($description)) {
        $_SESSION['error'] = "All fields are required!";
    }

    $result = $guideline->addHealthGuidelines($title, $description);
    if ($result) {
        $_SESSION['success'] = "Guideline created successfully!";
    } else {
        $_SESSION['error'] = "Failed to add guideline";
    }
    header('Location: health-guidelines.php');
    exit();
}
