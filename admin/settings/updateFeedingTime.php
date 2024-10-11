<?php
session_start();
require_once '../core/settingsController.php';
require_once '../core/inventoryController.php';

$settingsController = new settingsController();
$inventoryController = new inventoryController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $schedTime = $_POST['schedTime'] ?? null;
    $penId = $_POST['penId'] ?? null;
    $feedsType = $_POST['feedingType'] ?? null;
    $status = $_POST['status'] ?? null;
    $schedId = $_POST['schedId'] ?? null;

    if (empty($schedTime) || empty($penId) || empty($feedsType) || empty($status)) {
        $_SESSION['error'] = "All fields are required!";
    } else {
        $allSuccess = true;

        if ($penId === 'all') {
            $pens = $inventoryController->getPigPens();

            foreach ($pens as $pen) {
                $penSchedule = $settingsController->getScheduleForPen($pen['penId']);
                if (!$penSchedule) {
                    $allSuccess = false;
                    $_SESSION['error'] = "Failed to find schedule for Pen ID: " . $pen['penId'];
                    break;
                }
                $schedUpdated = $settingsController->updateSchedFeedingTime($pen['penId'], $schedTime, $status);

                if ($schedUpdated) {
                    $feedingResult = $settingsController->updateFeedingTime($pen['penId'], $penSchedule['schedId'], $feedsType);
                    if (!$feedingResult) {
                        $allSuccess = false;
                        $_SESSION['error'] = "Failed to update feeding for Pen ID: " . $pen['penId'];
                        break;
                    }
                } else {
                    $allSuccess = false;
                    $_SESSION['error'] = "Failed to update schedule for Pen ID: " . $pen['penId'];
                    break;
                }
            }

            if ($allSuccess) {
                $_SESSION['success'] = 'Feeding Time Successfully Updated for All Pens!';
            }
        } else {
            // Update schedule for a specific pen
            $schedUpdated = $settingsController->updateSchedFeedingTime($penId, $schedTime, $status);

            if ($schedUpdated) {
                // Update feeding for the specific pen
                $feedingResult = $settingsController->updateFeedingTime($penId, $schedId, $feedsType);
                if ($feedingResult) {
                    $_SESSION['success'] = 'Feeding Time Successfully Updated for Pen ID: ' . $penId;
                } else {
                    $_SESSION['error'] = "Failed to Update Feeding Time for Pen ID: " . $penId;
                }
            } else {
                $_SESSION['error'] = "Failed to Update Schedule for Pen ID: " . $penId;
            }
        }
    }

    // Redirect back to the feeding time page
    header('Location: feedingTime.php');
    exit();
}
