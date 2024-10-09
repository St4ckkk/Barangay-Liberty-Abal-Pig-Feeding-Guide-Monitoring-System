<?php
require_once '../core/pigController.php';

$pigController = new pigsController();
$success = '';
$error = '';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? null;
    $description = $_POST['description'] ?? null;

    if (empty($name) || empty($description)) {
        $error = "All fields are required!";
    } else {
        $success = $pigController->addBreeds($name, $description);
        if ($success) {
            header('Location: manageBreeds.php');
            exit;
        }
    }
}
