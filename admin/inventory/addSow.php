<?php
// session_start();
require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $sowId = $_POST['sow_id'] ?? null;
    $penno = $_POST['penno'] ?? null;
    $breed = $_POST['breed'] ?? null;
    $birthdate = $_POST['birth_date'] ?? null;
    $weight = $_POST['weight_kg'] ?? null;
    $acquisition_date = $_POST['acquisition_date'] ?? null;
    $status = $_POST['status'] ?? null;



    $result = $inventory->addSows($sowId, $penno, $breed, $birthdate, $weight, $acquisition_date, $status);
    if ($result) {
        $_SESSION['success'] = "Sows created successfully!";
    } else {
        $_SESSION['error'] = "Failed to add Sows";
    }
    header('Location: sow.php');
    exit();
}
