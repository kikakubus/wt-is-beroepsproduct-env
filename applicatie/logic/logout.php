<?php 
session_start();
$_SESSION['success'] = "Successfully logged out";
unset($_SESSION['loggedIn']);
unset($_SESSION['counter']);
header('Location: ../index.php');