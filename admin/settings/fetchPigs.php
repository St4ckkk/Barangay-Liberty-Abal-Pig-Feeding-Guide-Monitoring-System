<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once '../core/Database.php';
require_once '../core/settingsController.php';

header('Content-Type: application/json');

function handleError($errno, $errstr, $errfile, $errline)
{
    $error = [
        'error' => true,
        'message' => $errstr,
        'file' => $errfile,
        'line' => $errline
    ];
    echo json_encode($error);
    exit;
}

set_error_handler('handleError');

try {
    $penId = $_GET['penId'] ?? null;

    if ($penId) {
        $settingsController = new settingsController();
        $pigs = $settingsController->getPigsByPen($penId);

        if ($pigs) {
            $formattedPigs = array_map(function ($pig) {
                return [
                    'id' => $pig['pig_id'] ?? null,
                    'name' => $pig['ear_tag_number'] ?? "Pig " . ($pig['pig_id'] ?? 'Unknown')
                ];
            }, $pigs);

            echo json_encode($formattedPigs);
        } else {
            echo json_encode([]);
        }
    } else {
        echo json_encode(['error' => 'Pen ID not provided']);
    }
} catch (Exception $e) {
    echo json_encode(['error' => true, 'message' => $e->getMessage()]);
}
