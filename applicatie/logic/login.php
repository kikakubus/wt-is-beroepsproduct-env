<?php 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    unset($_SESSION['loggedIn']);
    unset($_SESSION['counter']);
    
    $counterNumber = $_POST['counter'];
    $pass = $_POST['password'];
    
    $sql = "SELECT * FROM Balie
            WHERE 
            balienummer = :balienummer";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':balienummer', $counterNumber);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (password_verify($pass, $results['wachtwoord'])) {
        $_SESSION['loggedIn'] = true;
        $_SESSION['counter'] = $counterNumber;
        $_SESSION['success'] = "Successfully logged in as counter ".$counterNumber;
        header('Location: index.php');
    } else {
        $_SESSION['error'] = "Counter number or password incorrect";
        header('Location: '.$_SERVER['REQUEST_URI']);
    }
}
?>