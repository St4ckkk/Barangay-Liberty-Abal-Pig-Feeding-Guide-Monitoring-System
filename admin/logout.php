<?php
session_start();
include_once 'core/SessionController.php';
$session = new SessionController();
$session->logout();
