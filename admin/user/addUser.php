<?php
session_start(); // Start the session to use $_SESSION

require_once '../core/userController.php';

$userController = new userController();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['username'] ?? null;
    $role = $_POST['role'] ?? null;
    $password = $_POST['password'] ?? null;

    if (empty($username) || empty($role)) {
        $_SESSION['error'] = "All fields are required!";
    } else {
        if ($role === 'worker') {
            $password = 'worker';
        } elseif (empty($password)) {
            $password = 'admin';
        }

        $status = 'Inactive';


        if (!isset($_SESSION['error'])) {
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $result = $userController->createUsers($username, $hashedPassword, $status, $role);
            if ($result) {
                $_SESSION['success'] = "User created successfully!";
            } else {
                $_SESSION['error'] = "Failed to add User";
            }

            header('Location: user.php');
            exit();
        }
    }
}
