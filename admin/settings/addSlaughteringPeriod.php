<?php
require_once '../core/settingsController.php';

$settingsController = new settingsController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedPigs = isset($_POST['selectedPigs']) ? explode(',', $_POST['selectedPigs']) : []; // Convert to array
    $penId = $_POST['penId'] ?? null;
    $slaughteringDate = $_POST['slaughteringDate'] ?? null;
    $slaughteringTime = $_POST['slaughteringTime'] ?? null;
    $schedType = 'Slaughtering';

    if (empty($selectedPigs) || empty($penId) || empty($slaughteringDate) || empty($slaughteringTime)) {
        $error = "All fields are required!";
    } else {
        foreach ($selectedPigs as $pigId) {
            $result = $settingsController->addSlaughteringPeriod($penId, $pigId, $slaughteringDate, $slaughteringTime);
            if (!$result) {
                $_SESSION['error'] = "Failed to add Slaughtering Period for pig ID: $pigId";
                break;
            }

            $scheduleResult = $settingsController->addSlaughteringSched($penId, $slaughteringTime, $slaughteringDate, $schedType); // Add slaughtering schedule
            if (!$scheduleResult) {
                $_SESSION['error'] = "Failed to add to the Schedule for pig ID: $pigId";
                break;
            }
        }

        if (!isset($_SESSION['error'])) {
            $_SESSION['success'] = 'Slaughtering Period and Schedule Successfully Added for selected pigs!';
        }

        header('Location: slaughteringPeriod.php');
        exit();
    }
}
