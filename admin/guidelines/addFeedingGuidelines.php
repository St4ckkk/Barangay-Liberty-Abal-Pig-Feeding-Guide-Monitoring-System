<?php

require_once '../core/guidelinesController.php';

$guideline = new guidelinesController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'] ?? '';
    $pigStage = $_POST['pigStage'] ?? '';
    $weightRange = $_POST['weightRange'] ?? '';
    $feedType = $_POST['feedType'] ?? '';
    $proteinContent = $_POST['proteinContent'] ?? '';
    $feedingFrequency = $_POST['feedingFrequency'] ?? '';
    $amountPerFeeding = $_POST['amountPerFeeding'] ?? '';
    $specialInstructions = $_POST['specialInstructions'] ?? '';

    if (empty($title) || empty($pigStage) || empty($feedType) || empty($proteinContent) || empty($amountPerFeeding)) {
        $_SESSION['error'] = "Title, Pig Stage, Feed Type, Protein Content, and Amount per Feeding are required!";
    } else {
        $result = $guideline->addFeedingGuidelines($title, $pigStage, $weightRange, $feedType, $proteinContent, $feedingFrequency, $amountPerFeeding, $specialInstructions);
        if ($result) {
            $_SESSION['success'] = "Guideline created successfully!";
        } else {
            $_SESSION['error'] = "Failed to add guideline";
        }
    }
    header('Location: feeding-guidelines.php');
    exit();
}