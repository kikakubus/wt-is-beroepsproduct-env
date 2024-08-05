<?php 
require_once 'database/conn.php';
require_once 'functions/functions.php';
require_once 'logic/defines.php';
session_start();
$conn = makeConnection();

if (!isset($_GET['page'])) {
    $_GET['page'] = "home";
}

// Define the default active page
$activePage = isset($_GET['page']) ? $_GET['page'] : 'home';
$currentUrl = $_SERVER['REQUEST_URI'];

$_SESSION['url'] = $currentUrl;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing</title>
    <link rel="stylesheet" type="text/css" href="css/css.css">
</head>

<body>


<!-- Navbar -->
<nav class="topnav mms-round">
    <a <?php if ($_GET['page'] == 'home') echo 'class="active"'; ?> href="index.php?page=home">Home</a>
    <a <?php if ($_GET['page'] == 'flights') echo 'class="active"'; ?> href="index.php?page=flights">Flights</a>
    <a <?php if ($_GET['page'] == 'checkin') echo 'class="active"'; ?> href="index.php?page=checkin">Check-in</a>
    <a <?php if ($_GET['page'] == 'login') echo 'class="active "'; ?> href="index.php?page=login">Login</a>
</nav>

<!-- Content -->
<main>
    <?php
    include 'logic/warning.php';
    
    // Include the active page content dynamically
    switch ($activePage) {
        case 'home':
            include('pages/home.php');
            break;
        case 'flights':
            include('pages/flightOverview.php');
            break;
        case 'flightDetails':
            include('pages/flightDetails.php');
            break;
        case 'addPassenger':
            include('pages/addPassenger.php');
            break;
        case 'checkin':
            include('pages/checkin.php');
            break;
        case 'login':
            include('pages/login.php');
            break;
        default:
            include('pages/home.php');
            break;
    }
    
    
    ?>
</main>

<footer class="footer">Footer</footer>

</body>
</html>