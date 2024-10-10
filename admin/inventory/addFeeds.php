<?php
// session_start();
require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $feedsName = $_POST['feedName'] ?? null;
    $feedsDescription = $_POST['feedDescription'] ?? null;
    $QtyOFoodPerSack = $_POST['QtyOFoodPerSack'] ?? null;

    if (empty($feedsName) || empty($feedsDescription) || empty($QtyOFoodPerSack)) {
        $_SESSION['error'] = "All fields are required!";
    }

    $result = $inventory->addFeedStocks($feedsName, $feedsDescription, $QtyOFoodPerSack);
    if ($result) {
        $_SESSION['success'] = "Feeds created successfully!";
    } else {
        $_SESSION['error'] = "Failed to add Feeds";
    }
    header('Location: feedStocks.php');
    exit();
}
