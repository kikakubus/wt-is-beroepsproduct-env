<?php
namespace Database;

use PDO;
use PDOException;
//namespace Database;

// Database connection parameters
$host = '127.0.0.1';  // Database host, usually '127.0.0.1' or 'localhost'
$db   = 'test';  // The name of the database
$user = 'root';  // The username for the database
$pass = '';  // The password for the database user
$charset = 'utf8mb4';  // The character set

// DSN (Data Source Name) for PDO
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

//PDO options
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch associative arrays by default
    PDO::ATTR_EMULATE_PREPARES   => false, // Disable emulation of prepared statements for increased security
];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // Handle any connection errors
    echo "Database connection failed: " . $e->getMessage();
}
?>