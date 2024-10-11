<?php
require_once '../core/settingsController.php';

$settings = new settingsController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penId = $_POST['penno'] ?? null;
    $damId = $_POST['dams'] ?? null;
    $sireId = $_POST['sire'] ?? null;
    $healthStatus = $_POST['health_status'] ?? null;
    $breedingDate = $_POST['breeding_date'] ?? null;
    $expectedFarrowingDate = $_POST['expected_farrowing_date'] ?? null;
    $pregnancyStatus = $_POST['pregnancy_status'] ?? null;
    $litterSize = $_POST['litter_size'] ?? null;
    $notes = $_POST['notes'] ?? null;

    // Validate required fields
    if (!$penId || !$damId || !$sireId || !$breedingDate || !$expectedFarrowingDate) {
        $error = "Please fill in all required fields.";
        $_SESSION['error'] = $error;
        header("Location: farrowingPeriod.php");
        exit();
    } 

    // Call the addFarrowingPeriod method with proper data
    $result = $settings->addFarrowingPeriod(
        $damId, // pigId (assuming this is the damId in your context)
        $penId, 
        $breedingDate, 
        $expectedFarrowingDate, 
        $sireId, 
        $pregnancyStatus, 
        $healthStatus, 
        $litterSize, 
        $notes
    );

    if ($result) {
        $success = "Farrowing period added successfully.";
        $_SESSION['success'] = $success;
    } else {
        $error = "Failed to add farrowing period. Please try again.";
        $_SESSION['error'] = $error;
    }

    // Redirect back to the form page
    header("Location: farrowingPeriod.php");
    exit();
}
?>
