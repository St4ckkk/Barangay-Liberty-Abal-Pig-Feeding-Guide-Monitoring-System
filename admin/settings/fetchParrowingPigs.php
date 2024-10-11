<?php
require_once '../core/settingsController.php';
header('Content-Type: application/json');

if (isset($_GET['pen_id'])) {
    $penId = $_GET['pen_id'];
    $settingsController = new settingsController();
    $pigs = $settingsController->getFemaleDams($penId);

    echo json_encode($pigs);
} else {
    echo json_encode([]);
}
