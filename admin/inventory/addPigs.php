<?php
require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $etn = $_POST['etn'] ?? null;
    $penId = $_POST['penId'] ?? null;
    $status = $_POST['status'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $breed = $_POST['breed'] ?? null;
    $pigType =  $_POST['pigType'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $age = $_POST['age'] ?? null;
    $notes = $_POST['notes'] ?? null;
    $penCapacity = $inventory->getPenCapacity($penId);

    if ($penCapacity > 0) {
        $result = $inventory->addPigs(
            $etn,
            $penId,
            $status,
            $gender,
            $breed,
            $pigType,
            $weight,
            $age,
            $notes
        );

        if ($result) {
            $inventory->decreasePenCapacity($penId);
            $_SESSION['success'] = "Pig added successfully!";
        } else {
            $_SESSION['error'] = "Ear tag number already exists.";
        }
    } else {
        $_SESSION['error'] = "Pigpen is full. Cannot add more pigs.";
    }

    header("Location: pigs.php?penId=" . urlencode($penId));
    exit();
}
