<?php

require_once '../core/inventoryController.php';

$inventory = new inventoryController();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $pigId = $_GET['id'];

    $penId = $inventory->getPenIdByPigId($pigId);

    $result = $inventory->removePig($pigId, $penId);

    if ($result) {
        $_SESSION['success'] = "Pig removed successfully!";
    } else {
        $_SESSION['error'] = "Failed to remove the pig.";
    }

    header("Location: pigs.php?penId=" . urlencode($penId));
    exit();
}
