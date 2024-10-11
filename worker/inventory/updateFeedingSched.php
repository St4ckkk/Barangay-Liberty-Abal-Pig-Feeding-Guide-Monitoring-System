<?php
require_once '../core/inventoryController.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penId = isset($_POST['penId']) ? $_POST['penId'] : null;
    $schedId = isset($_POST['schedId']) ? $_POST['schedId'] : null;

    if ($penId > 0 && $schedId > 0) {
        $inventoryController = new inventoryController();

        if ($inventoryController->updateFeedingSched($penId, $schedId)) {
            $_SESSION['success'] = 'Feeding schedule updated successfully.';
        } else {
            $_SESSION['error'] = 'Failed to update feeding schedule. Please try again.';
        }
    } else {
        $_SESSION['error'] = 'Invalid pen ID or schedule ID.';
    }
    header("Location: pigs.php?penId=" . urlencode($penId));
    exit();
}
