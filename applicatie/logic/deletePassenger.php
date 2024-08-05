<?php

require_once '../database/conn.php';
$conn = makeConnection();

session_start();

$nummer = $_GET['number'];

$_SESSION['success'] = 'Passenger deleted successfully';

try {
    // Insert passenger data into the database
    $sql = "DELETE FROM Passagier WHERE passagiernummer = :number";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':number', $nummer);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Passenger deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting passenger';
    }
} catch(PDOException $e) {
    $_SESSION['error'] = 'Error deleting passenger';
}

header('Location: '.$_SESSION['url']);

die();
?>