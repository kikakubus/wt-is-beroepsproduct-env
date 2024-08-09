<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    require_once '../database/conn.php';
    $conn = makeConnection();

    session_start();

    $passenger = $_POST['passenger'];
    $flight = $_POST['flight'];
    $date = date("Y-m-d H:i:s");
    
    try {
        $sql = "SELECT * FROM Passagier
                WHERE 
                passagiernummer = :passagiernummer AND
                vluchtnummer = :vluchtnummer AND
                EXISTS (SELECT * FROM Vlucht WHERE vluchtnummer = :vluchtnummer2 AND vertrektijd > :date)";
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':passagiernummer', $passenger);
        $stmt->bindParam(':vluchtnummer', $flight);
        $stmt->bindParam(':vluchtnummer2', $flight);
        $stmt->bindParam(':date', $date);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $stmt->rowCount();
        
        if ($count) {
            $sql = "UPDATE Passagier SET inchecktijdstip = :date
                WHERE
                passagiernummer = :passagiernummer AND
                vluchtnummer = :vluchtnummer";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':date', $date);
            $stmt->bindParam(':passagiernummer', $passenger);
            $stmt->bindParam(':vluchtnummer', $flight);
            $stmt->execute();
            
            $_SESSION['success'] = "Check-in success";
        } else {
            $_SESSION['error'] = "Checkin-in failed";
        }
    } catch(PDOException $e) {
        $_SESSION['error'] = "Checkin-in failed";
    }

    header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>