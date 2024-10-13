+<?php
    require_once '../core/inventoryController.php';

    $controller = new inventoryController();

    $success = '';
    $error = '';


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id = $_POST['feedId'] ?? null;


        if (empty($id)) {
            $_SESSION['error'] = 'Please fill in all required fields.';
        } else {
            if ($controller->deleteFeedStocks(
                $id
            )) {
                $_SESSION['success'] = 'Feed deleted successfully.';
                header('Location: feedStocks.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to delete feed.';
                header('Location: feedStocks.php');
                exit();
            }
        }
    }
