<?php
require_once __DIR__ . '/classes/class_session.php';
$session = new Session();
$session->logout();

header('Location: /login-systeem/loginpage.php');