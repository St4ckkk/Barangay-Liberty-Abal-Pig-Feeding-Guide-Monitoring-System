<?php
require_once '../core/inventoryController.php';

$controller = new inventoryController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penId = $_POST['penId'] ?? null;
    $id = $_POST['pig_id'] ?? null;
    $etn = $_POST['etn'] ?? null;
    $status = $_POST['status'] ?? null;
    $pigType = $_POST['pigType'] ?? null;
    $gender = $_POST['gender'] ?? null;
    $breed = $_POST['breed'] ?? null;
    $weight = $_POST['weight'] ?? null;
    $age = $_POST['age'] ?? null;
    $notes = $_POST['notes'] ?? null;

    if (empty($id) || empty($etn) || empty($status) || empty($pigType) || empty($gender) || empty($weight) || empty($age)) {
        $_SESSION['error'] = 'Please fill in all required fields.';
        header('Location: editPig.php'); // Redirect back to the edit page
        exit();
    } else {
        if ($controller->updatePig(
            $id,
            $etn,
            $status,
            $gender,
            $breed,
            $pigType,
            $weight,
            $age,
            $notes
        )) {
            $_SESSION['success'] = 'Pig details updated successfully.';
            header("Location: pigs.php?penId=" . urlencode($penId));
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update pig details.';
            header("Location: pigs.php?penId=" . urlencode($penId));
            exit();
        }
    }
}
