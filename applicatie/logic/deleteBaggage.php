<?php
require_once '../database/conn.php';
$conn = makeConnection();

session_start();

$nummer = $_GET['number'];
$passengerNumber = $_GET['passenger'];

try {
    // Insert passenger data into the database
    $sql = "DELETE FROM BagageObject WHERE objectvolgnummer = :objectvolgnummer AND passagiernummer = :passagiernummer";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':objectvolgnummer', $nummer);
    $stmt->bindParam(':passagiernummer', $passengerNumber);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Baggage deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting baggage';
    }
} catch(PDOException $e) {
    $_SESSION['error'] = 'Error deleting baggage';
}

header('Location: '.$_SERVER['HTTP_REFERER']);
?>