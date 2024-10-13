<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $frequency = $_POST['feedingFrequency'] ?? '';
    $morningTime = $_POST['morningTime'] ?? null;
    $noonTime = $_POST['noonTime'] ?? null;
    $eveningTime = $_POST['eveningTime'] ?? null;

    if (empty($id) || empty($frequency)) {
        $_SESSION['error'] = "Feeding ID and frequency are required.";
        header('Location: feedingPeriod.php');
        exit();
    }

    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    // Fetch the existing feeding period data
    try {
        $existingData = $settingsController->getFeedingPeriods($id);
        if (!$existingData) {
            $_SESSION['error'] = "Feeding period not found.";
            header('Location: feedingPeriod.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header('Location: feedingPeriod.php');
        exit();
    }

    // Use null if no time is provided
    if ($morningTime === '' || $morningTime === null) {
        $morningTime = null; // Leave as null if no time is provided
    } else {
        $morningTime = filter_var($morningTime, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if ($noonTime === '' || $noonTime === null) {
        $noonTime = null;
    } else {
        $noonTime = filter_var($noonTime, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    if ($eveningTime === '' || $eveningTime === null) {
        $eveningTime = null;
    } else {
        $eveningTime = filter_var($eveningTime, FILTER_SANITIZE_SPECIAL_CHARS);
    }

    // Remove times based on the new frequency
    if ($frequency === 'once') {
        $noonTime = null;  // Set noon time to null for 'once' frequency
        $eveningTime = null; // Set evening time to null for 'once' frequency
    } elseif ($frequency === 'twice') {
        $noonTime = null;  // Set noon time to null for 'twice' frequency
        // Keep morning and evening times for 'twice' frequency
    }
    // For 'thrice' or 'custom', keep all feeding times

    // Prepare the changes
    $changes = [];
    if ($frequency !== $existingData['feeding_frequency']) {
        $changes['feeding_frequency'] = $frequency;
    }
    if ($morningTime !== $existingData['morning_feeding_time']) {
        $changes['morning_feeding_time'] = $morningTime;
    }
    if ($noonTime !== $existingData['noon_feeding_time']) {
        $changes['noon_feeding_time'] = $noonTime;
    }
    if ($eveningTime !== $existingData['evening_feeding_time']) {
        $changes['evening_feeding_time'] = $eveningTime;
    }

    // If no changes were made, redirect back without updating
    if (empty($changes)) {
        $_SESSION['info'] = "No changes were made to the feeding schedule.";
        header('Location: feedingPeriod.php');
        exit();
    }

    // Validate the changes based on the new frequency
    if (isset($changes['feeding_frequency'])) {
        if ($frequency == 'once' && empty($morningTime)) {
            $_SESSION['error'] = "Morning feeding time is required for once a day frequency.";
            header('Location: feedingPeriod.php');
            exit();
        } elseif ($frequency == 'twice' && (empty($morningTime) || empty($eveningTime))) {
            $_SESSION['error'] = "Morning and evening feeding times are required for twice a day frequency.";
            header('Location: feedingPeriod.php');
            exit();
        } elseif (($frequency == 'thrice' || $frequency == 'custom') &&
            (empty($morningTime) || empty($noonTime) || empty($eveningTime))
        ) {
            $_SESSION['error'] = "All feeding times are required for thrice a day or custom frequency.";
            header('Location: feedingPeriod.php');
            exit();
        }
    }

    try {
        $result = $settingsController->updateFeedingPeriod($id, $changes);

        if ($result) {
            $notificationSent = $settingsController->sendNotification(
                "Feeding Schedule Updated",
                "A feeding schedule has been updated. Please check for details.",
                $id,
                "Feeding Schedule",
                true
            );

            if ($notificationSent) {
                $_SESSION['success'] = "Feeding schedule updated successfully and notification sent.";
            } else {
                $_SESSION['success'] = "Feeding schedule updated successfully, but there was an issue sending the notification.";
            }
        } else {
            $_SESSION['error'] = "Error updating feeding schedule.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    }

    header('Location: feedingPeriod.php');
    exit();
} else {
    header('Location: feedingPeriod.php');
    exit();
}
