<?php
//known data
$passenger = "";
$oldPassenger = "";
$name = "";
$sex = "";
$seat = "";
$male = "";
$female = "";
$other = "";
if (isset($_GET['id']))
{
    $passengerData = fGetBaseObject('Passagier', 'passagiernummer', $_GET['id']);
    
    $passenger = $passengerData['passagiernummer'];
    $oldPassenger = $_GET['id'];
    $name = $passengerData['naam'];
    $sex = $passengerData['geslacht'];
    $seat = $passengerData['stoel'];
    
    $male = "";
    $female = "";
    $other = "";
    if ($sex == 'M') {
        $male = "selected";
    } elseif ($sex == 'V') {
        $female = "selected";
    } elseif ($sex == 'x') {
        $other = "selected";
    }
}

//post data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $flightID = $_POST['flightID'];
    $oldFlightID = $_POST['oldFlightID'];
    $name = $_POST['name'];
    $passenger = $_POST['passenger'];
    $oldPassenger = $_POST['oldPassenger'];
    $sex = $_POST['sex'];
    $counterNumber = $_SESSION['counter'];
    $seat = $_POST['seat'];
    $date = NULL;
    $pass = "unsafe-pass";
    
    $data = array(
        'naam' => $name,
        'passagiernummer' => $passenger,
        'vluchtnummer' => $flightID,
        'geslacht' => $sex,
        'balienummer' => $counterNumber,
        'stoel' => $seat,
        'inchecktijdstip' => $date,
        'wachtwoord' => $pass
    );
    
    $now = date("Y-m-d H:i:s");
    $flightExists = fGetCount('Vlucht', 'vluchtnummer', $flightID, 'vluchtnummer', " AND vertrektijd > '".$now."'");

    if ($flightExists > 0) {
        if ($oldPassenger != "") {
            if (fInsertObject('Passagier', $data, 'passagiernummer', $oldPassenger)) {
                $_SESSION['success'] = 'Passenger updated successfully';
                header('Location: ../index.php?page=flightDetails&id='.$_POST['oldFlightID'].'');
            } else {
                $_SESSION['error'] = 'Error updating passenger';
                header('Location: '.$_SERVER['REQUEST_URI']);
            }
        } elseif (fInsertObject('Passagier', $data)) {
            $_SESSION['success'] = 'Passenger added successfully';
            header('Location: ../index.php?page=flightDetails&id='.$_POST['oldFlightID'].'');
        } else {
            $_SESSION['error'] = 'Error adding passenger';
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
    } else {
        $_SESSION['error'] = 'Flight doesnt exist or has already departed';
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
    die();
}
?>