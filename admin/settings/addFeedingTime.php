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
    $feedsType = $_POST['feedingType'] ?? null;
    $status = 'Pending';

    if (empty($schedTime) || empty($penId) || empty($feedsType)) {
        $error = "All fields are required!";
    } else {
        $schedType = 'Feeding';

        if ($penId === 'all') {
            $pens = $inventoryController->getPigPens();
            $allSuccess = true;

            foreach ($pens as $pen) {
                $schedId = $settingsController->addSchedForFeedingTime(
                    $pen['penId'],
                    $schedTime,
                    $schedType,
                    $status
                );

                if ($schedId) {
                    $feedingResult = $settingsController->addFeedingTime($pen['penId'], $schedId, $feedsType);
                    if (!$feedingResult) {
                        $allSuccess = false;
                        break;
                    }
                } else {
                    $allSuccess = false;
                    break;
                }
            }

            if ($allSuccess) {
                $_SESSION['success'] = 'Feeding Time Successfully Added to All Pens!';
            } else {
                $_SESSION['error'] = "Failed to add Feeding Time for some or all Pens";
            }
        } else {
            $schedId = $settingsController->addSchedForFeedingTime(
                $penId,
                $schedTime,
                $schedType,
                $status
            );

            if ($schedId) {
                $feedingResult = $settingsController->addFeedingTime($penId, $schedId, $feedsType);
                if ($feedingResult) {
                    $_SESSION['success'] = 'Feeding Time Successfully Added for Pen ID: ' . $penId;
                } else {
                    $_SESSION['error'] = "Failed to add Feeding Time for Pen ID: " . $penId;
                }
            } else {
                $_SESSION['error'] = "Failed to add Schedule for Pen ID: " . $penId;
            }
        }
        header('Location: feedingTime.php');
        exit();
    }
}
