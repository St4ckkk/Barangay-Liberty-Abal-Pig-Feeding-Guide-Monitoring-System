<?php
require_once '../core/pigController.php';

$pigController = new pigsController();
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $earTagNumber = $_POST['ear_tag_number'] ?? null;
    $breed = $_POST['breed'] ?? null;
    $birthDate = $_POST['birth_date'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $healthStatus = $_POST['health_status'] ?? null;
    $penNumber = $_POST['pen_number'] ?? null;
    $gender = $_POST['gender'] ?? null;

    if (empty($earTagNumber) || empty($breed) || empty($birthDate) || empty($weight) || empty($healthStatus) || empty($penNumber) || empty($gender)) {
        $error = "All fields are required!";
    } else {
        $success = $pigController->addPigs($earTagNumber, $breed, $birthDate, $weight, $healthStatus, $penNumber, $gender);
        if ($success) {
            header('Location: pigsList.php');
            exit;
        }

    }
}


