<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once '../database/conn.php';
    require_once '../functions/functions.php';
    $conn = makeConnection();

    session_start();

    $flight = $_POST['flight'];
    $passenger = $_POST['passenger'];
    $weight = $_POST['weight'];
    $objectvolgnummer = fGetMax('BagageObject', 'passagiernummer', $passenger, 'objectvolgnummer') + 1;
    
    $sumWeight = fGetSum('BagageObject', 'passagiernummer', $passenger, 'gewicht') + $weight;
    $weightPP = fGetName('Vlucht', 'vluchtnummer', $flight, 'max_gewicht_pp');
    $weightTotal = fGetName('Vlucht', 'vluchtnummer', $flight, 'max_totaalgewicht');

    $allPassengers = fGetAllObjects('Passagier', 'vluchtnummer', $flight);
    $totalWeight = 0;
    foreach ($allPassengers as $passengerInfo) {
        $totalWeight += fGetSum('BagageObject', 'passagiernummer', $passengerInfo['passagiernummer'], 'gewicht');
    }
    $totalWeight += $weight;

    if ($sumWeight <= $weightPP && $totalWeight <= $weightTotal) {
        $data = array(
            'passagiernummer' => $passenger,
            'gewicht' => $weight,
            'objectvolgnummer' => $objectvolgnummer
        );

        try {
            if (fInsertObject('BagageObject', $data)) {
                $_SESSION['success'] = 'Baggage added successfully';
            } else {
                $_SESSION['error'] = 'Error adding Baggage';
            }
        } catch(PDOException $e) {
            $_SESSION['error'] = "Checkin-in failed";
        }
    } else {
        $_SESSION['error'] = 'Weight is over the set limit';
    }

    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>