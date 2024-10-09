<?php

require_once '../core/userController.php';

$userController = new userController();
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'] ?? null;

    if (empty($username)) {
        $error = "All fields are required!";
    } else {
        if (empty($password)) {
            $password = 'admin';
        }
        $status = 'Inactive';

        if (!$error) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $result = $userController->createUsers($username, $hashedPassword, $status);
            if ($result) {
                $success = "User created successfully!";
                header('Location: user.php');
                exit();
            } else {
                $error = "Failed to add User";
            }
        }
    }
}
