<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../database/conn.php';
    require_once '../functions/functions.php';
    $conn = makeConnection();

    session_start();

    $vluchtnummer = fGetMax('Vlucht', '1', '1', 'vluchtnummer') + 1;
    $bestemming = $_POST['bestemming'];
    $gate = $_POST['gate'];
    $vertrektijd = strtotime($_POST['vertrektijd']);
    $vertrektijd = date('Y-m-d H:i:s', $vertrektijd);
    $airline = $_POST['airline'];
    $maxPassengers = $_POST['maxPassengers'];
    $maxWeight =  $_POST['maxWeight'];
    $maxWeightPP = $_POST['maxWeightPP'];

    $data = array(
        'vluchtnummer' => $vluchtnummer,
        'bestemming' => $bestemming,
        'gatecode' => $gate,
        'vertrektijd' => $vertrektijd,
        'maatschappijcode' => $airline,
        'max_gewicht_pp' => $maxWeightPP,
        'max_totaalgewicht' => $maxWeight,
        'max_aantal' => $maxPassengers
    );

    try {
        if (fInsertObject('Vlucht', $data)) {
            $_SESSION['success'] = 'Flight added successfully';
            header('Location: ../index.php?page=flights');
        } else {
            $_SESSION['error'] = 'Error adding flight';
            //header('Location: '.$_SERVER['HTTP_REFERER']);
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = 'Error adding flight';
        header('Location: '.$_SERVER['HTTP_REFERER']);
    } 
}
?>