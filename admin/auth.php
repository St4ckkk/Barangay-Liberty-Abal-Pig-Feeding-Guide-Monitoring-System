<?php
require_once 'core/SessionController.php';
$session = new SessionController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $session->login();
}