+<?php
    require_once '../core/inventoryController.php';

    $controller = new inventoryController();

    $success = '';
    $error = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['feedId'] ?? null;
        $feedsName = $_POST['feedName'] ?? null;
        $QtyOFoodPerSack = $_POST['QtyOFoodPerSack'] ?? null;
        $feedCost = $_POST['feedCost'] ?? null;
        $purchasedDate = $_POST['purchasedDate'] ?? null;
        $feedDescription = $_POST['feedDescription'] ?? null;


        if (empty($id) || empty($feedsName) || empty($QtyOFoodPerSack) || empty($feedCost) || empty($purchasedDate) || empty($feedDescription)) {
            $_SESSION['error'] = 'Please fill in all required fields.';
        } else {
            if ($controller->updateFeedStocks(
                $id,
                $feedsName,
                $feedDescription,
                $feedCost,
                $purchasedDate,
                $QtyOFoodPerSack
            )) {
                $_SESSION['success'] = 'Feed updated successfully.';
                header('Location: feedStocks.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to update feed.';
                header('Location: feedStocks.php');
                exit();
            }
        }
    }
