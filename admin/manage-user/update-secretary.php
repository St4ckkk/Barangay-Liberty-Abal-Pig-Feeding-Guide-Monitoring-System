<?php

require_once '../core/userController.php';
$userController = new userController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? null;
    $username = $_POST['username'] ?? null;
    $email = $_POST['email'] ?? null;
    $user_id = $_POST['user_id'] ?? null;  // Capture user_id

    // Validate inputs
    if (empty($name) || empty($username) || empty($email) || empty($user_id)) {
        $error = "All fields are required!";
    } else {
        // Pass user_id to the update function
        $result = $userController->updateSecretaryAccount($user_id, $name, $username, $email);

        if ($result) {
            $success = "Update successful!";
            header("Location: manage-user.php");
            exit;
        } else {
            $error = "Failed to update secretary!";
        }
    }
}
