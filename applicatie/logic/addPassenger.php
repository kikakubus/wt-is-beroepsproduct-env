<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $flightID = $_POST['flightID'];
    $name = $_POST['name'];
    $sex = $_POST['sex'];
    $counterNumber = $_POST['counterNumber'];
    $seat = $_POST['seat'];
    $date = date("Y-m-d H:i:s");
    
    print_r($_POST);
    
    // Insert passenger data into the database
    $sql = "INSERT INTO Passagier (naam, vluchtnummer, geslacht, balienummer, stoel, inchecktijdstip, wachtwoord)
                VALUES (:name, :flight, :sex, :counter, :seat, :date, '')";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':flight', $flightID);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':sex', $sex);
    $stmt->bindParam(':counter', $counterNumber);
    $stmt->bindParam(':seat', $seat);
    $stmt->bindParam(':date', $date);
    
    if ($stmt->execute()) {
        header('Location: ../index.php?page=flightDetails&id='.$_POST['flightID'].'');
    } else {
        echo "Error adding passenger.";
        die();
    }

    die();
}
?>