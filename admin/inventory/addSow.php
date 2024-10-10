<?php

require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $penId = $_POST['penno'] ?? null;
    $pigId = $_POST['pigs'] ?? null;
    $status = $_POST['status'] ?? null;

    if (empty($penId) || empty($pigId) || empty($status)) {
        $_SESSION['error'] = "All fields are required!";
    }

    $result = $inventory->addSows($penId, $pigId, $status);

    if ($result) {
        $_SESSION['success'] = "Sows created successfully!";
    } else {
        $_SESSION['error'] = "Failed to add Sows";
    }
    header('Location: sow.php');
    exit();
}
