<?php
require_once '../core/userController.php';

$user = new userController();

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'] ?? null;


    if (empty($userId) ) {
        $_SESSION['error'] = 'All fields are required.';
    } else {
        unset($_SESSION['error']);
        $result = $user->deleteUser($userId);
        
        if ($result) {
            header("Location: user.php");
            $_SESSION['success'] = 'User Delete successfully.';
        } else {
            header("Location: user.php");
            $_SESSION['error'] = 'Error deleting user.';
        }
    }
}
