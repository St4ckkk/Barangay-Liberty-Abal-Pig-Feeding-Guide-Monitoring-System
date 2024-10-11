<?php
// session_start();
require_once '../core/guidelinesController.php';

$guideline = new guidelinesController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $pigType = $_POST['pigType'] ?? null;
    $breed = $_POST['breed'] ?? null;
    $sex = $_POST['sex'] ?? null;
    $description = $_POST['description'] ?? null;

    if(empty($pigType) || empty($breed) || empty($sex) || empty($description)) {
        $_SESSION['error'] = "All fields are required!";
    }

    $result = $guideline->addPigs($pigType, $breed, $sex, $description);
    if ($result) {
        $_SESSION['success'] = "Type Of Pig created successfully!";
    } else {
        $_SESSION['error'] = "Failed to add Type Of Pig";
    }
    header('Location: pigs-guidelines.php');
    exit();
}
