<?php
require_once '../core/inventoryController.php';
header('Content-Type: application/json');

if (isset($_GET['pen_id'])) {
    $penId = $_GET['pen_id'];
    $inventoryController = new inventoryController();
    $pigs = $inventoryController->getPigsByPen($penId);

    echo json_encode($pigs);
} else {
    echo json_encode([]);
}
