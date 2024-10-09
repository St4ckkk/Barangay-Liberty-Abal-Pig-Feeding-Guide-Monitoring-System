<?php
session_start();
// Assuming you have a session variable for notifications
$_SESSION['notificationCount'] = 0;

// You can also reset it in your database if needed

echo json_encode(['status' => 'success']);
