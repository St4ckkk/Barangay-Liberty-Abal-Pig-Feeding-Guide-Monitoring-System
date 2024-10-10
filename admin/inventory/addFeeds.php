<?php
// session_start();
require_once '../core/inventoryController.php';

$inventory = new inventoryController();
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $feedsName = $_POST['feedName'] ?? null;
    $feedsDescription = $_POST['feedDescription'] ?? null;
    $feedsCost = $_POST['feedCost'] ?? null;
    $QtyOFoodPerSack = $_POST['QtyOFoodPerSack'] ?? null;
    $expenseType = "Feeds";

    if (empty($feedsName) || empty($feedsDescription) || empty($QtyOFoodPerSack)) {
        $_SESSION['error'] = "All fields are required!";
    } else {
        $result = $inventory->addFeedStocks($feedsName, $feedsDescription, $feedsCost, $QtyOFoodPerSack);

        if ($result) {
            $expenseAdded = $inventory->addExpense($feedsName, $expenseType, $feedsCost);

            if ($expenseAdded) {
                $_SESSION['success'] = "Feeds created and expense added successfully!";
            } else {
                $_SESSION['error'] = "Feeds created, but failed to add to expenses.";
            }
        } else {
            $_SESSION['error'] = "Failed to add Feeds.";
        }

        header('Location: feedStocks.php');
        exit();
    }
}
