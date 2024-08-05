<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $flightID = $_POST['flightID'];
    $name = $_POST['name'];
    $passenger = $_POST['passenger'];
    $sex = $_POST['sex'];
    $counterNumber = $_SESSION['counter'];
    $seat = $_POST['seat'];
    $date = NULL;
    $pass = "unsafe-pass";
    
    try {
        // Insert passenger data into the database
        $sql = "INSERT INTO Passagier (naam, passagiernummer, vluchtnummer, geslacht, balienummer, stoel, inchecktijdstip, wachtwoord)
                    VALUES (:name, :passagiernummer, :flight, :sex, :counter, :seat, :date, :pass)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':passagiernummer', $passenger);
        $stmt->bindParam(':flight', $flightID);
        $stmt->bindParam(':sex', $sex);
        $stmt->bindParam(':counter', $counterNumber);
        $stmt->bindParam(':seat', $seat);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':pass', $pass);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Passenger added successfully';
            header('Location: ../index.php?page=flightDetails&id='.$_POST['flightID'].'');
        } else {
            $_SESSION['error'] = 'Error adding passenger';
            header('Location: '.$_SERVER['REQUEST_URI']);
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = 'Error adding passenger';
        header('Location: '.$_SERVER['REQUEST_URI']);
    }

    die();
}
?>