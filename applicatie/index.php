<?php 
require_once 'Database/conn.php';

if (!isset($_GET['page'])) {
    $_GET['page'] = "home";
}

session_start();

// Define the default active page
$activePage = isset($_GET['page']) ? $_GET['page'] : 'home';
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

<header>
	<a href="index.php?page=home">
		<img class="headerImage" src="content/img/OnlyTheBest.png">
	</a>
</header>

<!-- Navbar -->
<nav class="topnav">
    <a <?php if ($_GET['page'] == 'home') echo 'class="active"'; ?> href="index.php?page=home">Home</a>
    <a <?php if ($_GET['page'] == 'about') echo 'class="active"'; ?> href="index.php?page=about">About</a>
</nav>

<!-- Content -->
<main>
    <?php
    // Include the active page content dynamically
    switch ($activePage) {
        case 'home':
            include('pages/home.php');
            break;
        case 'about':
            include('pages/about.php');
            break;
        case 'films':
            include('pages/films.php');
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