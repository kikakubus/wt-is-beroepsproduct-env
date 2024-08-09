<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once '../database/conn.php';
    require_once '../functions/functions.php';
    $conn = makeConnection();

    session_start();

    $passenger = $_POST['passenger'];
    $flight = $_POST['flight'];

    $passengerCount = fGetCount('Passagier', 'passagiernummer', $passenger, 'passagiernummer', " AND vluchtnummer = '$flight'");
    if ($passengerCount > 0) {
        header('Location: ../index.php?page=passengerDetails&id='.$passenger);
    } else {
        $_SESSION['error'] = "Passengernumber or flightnumber incorrect";
        header('Location: '.$_SERVER['HTTP_REFERER']);
    }
}
?>