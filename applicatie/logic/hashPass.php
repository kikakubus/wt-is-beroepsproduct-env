<?php 
require_once '../database/conn.php';
$conn = makeConnection();

$query = $conn->query("SELECT balienummer, wachtwoord FROM Balie");

while ($rij = $query->fetch()) {
    $hashedWachtwoord = password_hash('password', PASSWORD_DEFAULT);
    $updateQuery = $conn->prepare("UPDATE Balie SET wachtwoord = :wachtwoord WHERE balienummer = :balienummer");
    $updateQuery->execute(['wachtwoord' => $hashedWachtwoord, 'balienummer' => $rij['balienummer']]);
}

echo "Passwords hashed successfully!";

?>