<?php

require_once '../core/settingsController.php';
require_once '../core/inventoryController.php';

$settingsController = new settingsController();
$inventoryController = new inventoryController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedTime = $_POST['schedTime'] ?? null;
    $penId = $_POST['penId'] ?? null;

    if (empty($schedTime) || empty($penId)) {
        $error = "All fields are required!";
    } else {
        $schedType = 'Feeding';

        if ($penId === 'all') {
            $pens = $inventoryController->getPigPens();


            foreach ($pens as $pen) {
                $result = $settingsController->addSchedForFeedingTime(
                    $pen['penId'],
                    $schedTime,
                    $schedType,
                );

                if (!$result) {
                    $_SESSION['error'] = "Failed to add Feeding Time for Pen ID: " . $pen['penId'];
                    header('Location: feedingTime.php');
                    exit();
                }
            }

            $_SESSION['success'] = 'Feeding Time Successfully Added to All Pens!';
        } else {
            // Add feeding time for the specific pen
            $result = $settingsController->addSchedForFeedingTime(
                $penId,
                $schedTime,
                $schedType,
            ); // Use the selected pen ID

            if ($result) {
                $_SESSION['success'] = 'Feeding Time Successfully Added for Pen ID: ' . $penId;
            } else {
                $_SESSION['error'] = "Failed to add Feeding Time for Pen ID: " . $penId;
            }
        }
        header('Location: feedingTime.php');
        exit();
    }
}
