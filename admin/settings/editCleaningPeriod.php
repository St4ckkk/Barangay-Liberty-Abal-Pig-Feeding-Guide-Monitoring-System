<?php

require_once '../core/settingsController.php';

$settingsController = new settingsController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $frequency = $_POST['cleaningFrequency'] ?? '';
    $morningTime = $_POST['morningTime'] ?? null;
    $noonTime = $_POST['noonTime'] ?? null;
    $eveningTime = $_POST['eveningTime'] ?? null;

    if (empty($id) || empty($frequency)) {
        $_SESSION['error'] = "Cleaning ID and frequency are required.";
        header('Location: cleaningPeriod.php');
        exit();
    }

    $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

    // Fetch the existing feeding period data
    try {
        $existingData = $settingsController->getCleaningPeriods($id);
        if (!$existingData) {
            $_SESSION['error'] = "Cleaning period not found.";
            header('Location: cleaningPeriod.php');
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
        header('Location: cleaningPeriod.php');
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
    if ($frequency !== $existingData['cleaning_frequency']) {
        $changes['cleaning_frequency'] = $frequency;
    }
    if ($morningTime !== $existingData['morning_cleaning_time']) {
        $changes['morning_cleaning_time'] = $morningTime;
    }
    if ($noonTime !== $existingData['noon_cleaning_time']) {
        $changes['noon_cleaning_time'] = $noonTime;
    }
    if ($eveningTime !== $existingData['evening_cleaning_time']) {
        $changes['evening_cleaning_time'] = $eveningTime;
    }

    if (empty($changes)) {
        $_SESSION['info'] = "No changes were made to the feeding schedule.";
        header('Location: cleaningPeriod.php');
        exit();
    }


    if (isset($changes['cleaning_frequency'])) {
        if ($frequency == 'once' && empty($morningTime)) {
            $_SESSION['error'] = "Morning cleaning time is required for once a day frequency.";
            header('Location: cleaningPeriod.php');
            exit();
        } elseif ($frequency == 'twice' && (empty($morningTime) || empty($eveningTime))) {
            $_SESSION['error'] = "Morning and evening cleaning times are required for twice a day frequency.";
            header('Location: cleaning.php');
            exit();
        } elseif (($frequency == 'thrice' || $frequency == 'custom') &&
            (empty($morningTime) || empty($noonTime) || empty($eveningTime))
        ) {
            $_SESSION['error'] = "All cleaning times are required for thrice a day or custom frequency.";
            header('Location: cleaningPeriod.php');
            exit();
        }
    }

    try {
        $result = $settingsController->updateCleaningPeriod($id, $changes);

        if ($result) {
            $notificationSent = $settingsController->sendNotification(
                "Cleaning Schedule Updated",
                "A cleaning schedule has been updated. Please check for details.",
                $id,
                "Cleaning Schedule",
                true
            );

            if ($notificationSent) {
                $_SESSION['success'] = "Cleaning schedule updated successfully and notification sent.";
            } else {
                $_SESSION['success'] = "Cleaning schedule updated successfully, but there was an issue sending the notification.";
            }
        } else {
            $_SESSION['error'] = "Error updating feeding schedule.";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "An error occurred: " . $e->getMessage();
    }

    header('Location: cleaningPeriod.php');
    exit();
} else {
    header('Location: cleaningPeriod.php');
    exit();
}
