<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../core/Database.php';
require_once '../core/settingsController.php';

header('Content-Type: application/json');

$penId = $_GET['penId'] ?? null;

if ($penId) {
    $settingsController = new settingsController();
    $pigs = $settingsController->getPigsByPen($penId);

    if ($pigs) {        $formattedPigs = array_map(function ($pig) {
            return [
                'id' => $pig['pig_id'] ?? $pig['pig_id'] ?? null,
                'name' => $pig['ear_tag_number'] ?? $pig['ear_tag_number'] ?? "Pig " . ($pig['pig_id'] ?? $pig['pig_id'] ?? 'Unknown')
            ];
        }, $pigs);

        echo json_encode($formattedPigs);
    } else {
        echo json_encode([]); 
    }
} else {
    echo json_encode(['error' => 'Pen ID not provided']);
}
