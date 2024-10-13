<?php
require_once '../core/inventoryController.php';

$controller = new inventoryController();

$success = '';
$error = '';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penId = $_POST['penId'] ?? null;
    $penno = $_POST['penno'] ?? null;
    $pigCount = $_POST['penpigcount'] ?? null;
    $penStatus = $_POST['penstatus'] ?? null;

    if (
        empty($penId) ||
        empty($penno) ||
        empty($pigCount) ||
        empty($penStatus)
    ) {
        $_SESSION['error'] = 'Please fill in all required fields.';
    } else {
        if ($controller->updatePen(
            $penId,
            $penno,
            $penStatus,
            $pigCount

        )) {
            $_SESSION['success'] = 'Pen updated successfully.';
            header('Location: pen.php');
            exit();
        } else {
            $_SESSION['error'] = 'Failed to update pen.';
            header('Location: pen.php');
            exit();
        }
    }
}
