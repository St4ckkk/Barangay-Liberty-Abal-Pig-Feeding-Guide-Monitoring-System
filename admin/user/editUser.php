<?php
require_once '../core/userController.php';

$user = new userController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'] ?? null;
    $username = $_POST['username'] ?? null;
    $role = $_POST['role'] ?? null;
    $status = $_POST['status'] ?? null;

    if (empty($username) || empty($role) || empty($status)) {
        $_SESSION['error'] = 'All fields are required.';
    } else {
        unset($_SESSION['error']);
        $result = $user->editUser($userId, $username, $role, $status);

        if ($result) {
            header("Location: user.php");
            $_SESSION['success'] = 'User updated successfully.';
        } else {
            header("Location: user.php");
            $_SESSION['error'] = 'Error updating user.';
        }
    }
}
