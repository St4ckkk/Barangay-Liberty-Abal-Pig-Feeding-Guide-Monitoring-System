<?php

require_once '../core/guidelinesController.php';

$controller = new guidelinesController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $guide_id = $_POST['guide_id'] ?? null;
    $title = $_POST['title'] ?? null;
    $pig_stage = $_POST['pigStage'] ?? null;
    $weight_range = $_POST['weightRange'] ?? null;
    $feed_type = $_POST['feedType'] ?? null;
    $protein_content = $_POST['proteinContent'] ?? null;
    $feeding_frequency = $_POST['feedingFrequency'] ?? null;
    $amount_per_feeding = $_POST['amountPerFeeding'] ?? null;
    $special_instructions = $_POST['specialInstructions'] ?? null;


    if (empty($guide_id) || empty($title) || empty($pig_stage) || empty($weight_range) || empty($feed_type) || empty($protein_content) || empty($feeding_frequency) || empty($amount_per_feeding) || empty($special_instructions)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
    }

    if (empty($_SESSION['error'])) {
        if ($controller->updateFeedingGuidelines($guide_id, $title, $pig_stage, $weight_range, $feed_type, $protein_content, $feeding_frequency, $amount_per_feeding, $special_instructions)) {
            $_SESSION['success'] = 'Feeding guideline updated successfully.';
            header('Location: feeding-guidelines.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update feeding guideline.';
            header('Location: feeding-guidelines.php');
            exit();
        }
    }
}
