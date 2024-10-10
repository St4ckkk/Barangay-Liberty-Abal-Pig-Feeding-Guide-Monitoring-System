<?php
// session_start();
require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $penNo = $_POST['penno'] ?? null;
    $penStatus = $_POST['penstatus'] ?? null;
    $pigCount = $_POST['penpigcount'] ?? null;

    if (empty($penNo) || empty($penStatus) || empty($pigCount)) {
        $_SESSION['error'] = "All fields are required!";
    }

    $result = $inventory->addPigPens($penNo, $penStatus, $pigCount);
    if ($result) {
        $_SESSION['success'] = "Pig Pen created successfully!";
    } else {
        $_SESSION['error'] = "Failed to add Pig Pen";
    }
    header('Location: pen.php');
    exit();
}
