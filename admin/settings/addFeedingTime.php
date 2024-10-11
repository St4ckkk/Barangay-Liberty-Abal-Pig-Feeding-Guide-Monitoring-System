<?php

require_once '../core/settingsController.php';
require_once '../core/inventoryController.php';
require_once '../core/notificationController.php';

$settingsController = new settingsController();
$inventoryController = new inventoryController();
$notificationController = new notificationController();

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
                    if ($feedingResult) {
                        // Fetch penNo for notification
                        $penNoResult = $inventoryController->getPenNoById($pen['penId']);
                        $penNo = $penNoResult ? $penNoResult['penno'] : 'Unknown'; // Access the penno value

                        // Add notification for each pen using penNo
                        $notificationController->addNotification(
                            $pen['penId'],
                            $schedId,
                            "Feeding time for Pen No $penNo at $schedTime", // Use penNo in message
                            $schedTime
                        );
                    } else {
                        $allSuccess = false;
                        break;
                    }
                } else {
                    $allSuccess = false;
                    break;
                }
            }

            if ($allSuccess) {
                $_SESSION['success'] = 'Feeding Time Successfully Added to All Pens with Notifications!';
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
                    // Fetch penNo for notification
                    $penNoResult = $inventoryController->getPenNoById($penId);
                    $penNo = $penNoResult ? $penNoResult['penno'] : 'Unknown'; // Access the penno value

                    // Add notification for single pen using penNo
                    $notificationController->addNotification(
                        $penId,
                        $schedId,
                        "Feeding time for Pen No $penNo at $schedTime", // Use penNo in message
                        $schedTime
                    );
                    $_SESSION['success'] = 'Feeding Time Successfully Added for Pen ID: ' . $penId . ' with Notification!';
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


function checkNotifications()
{
    global $notificationController;
    $currentTime = date('Y-m-d H:i:s');
    $notifications = $notificationController->getActiveNotifications($currentTime);

    foreach ($notifications as $notification) {
        echo "<script>
            alert('Reminder: {$notification['message']}');
            // You can replace this with a more sophisticated notification system
        </script>";

        $notificationController->markNotificationAsDisplayed($notification['id']);
    }
}

checkNotifications();
