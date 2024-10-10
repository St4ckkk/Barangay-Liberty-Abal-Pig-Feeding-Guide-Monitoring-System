<?php
// session_start();
require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $etn = $_POST['ear_tag_number'] ?? null;
    $penId = $_POST['penId'] ?? null;
    $status = $_POST['status'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $health_status = $_POST['health_status'] ?? null;
    $breed = $_POST['breed'] ?? null;
    $acquisition_date = $_POST['acquisition_date'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $age = $_POST['age'] ?? null;
    $notes = $_POST['notes'] ?? null;


    $result = $inventory->addPigs(
        $etn,
        $penId,
        $status,
        $gender,
        $health_status,
        $breed,
        $acquisition_date,
        $weight,
        $age,
        $notes
    );
    if ($result) {
        $_SESSION['success'] = "Pigs added successfully!";
    } else {
        $_SESSION['error'] = "Failed to add Pigs";
    }
    header("Location: pigs.php?penId=" . urlencode($penId));
    exit();
}
