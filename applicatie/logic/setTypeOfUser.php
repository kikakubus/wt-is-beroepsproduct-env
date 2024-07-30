<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['userType'] = $_POST['userType'];
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>