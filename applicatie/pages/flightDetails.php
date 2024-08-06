<?php
$search_term = "";
if (isset($_POST['search']))
{
    $search_term = $_POST['search'];
}

// Fetch flight details
if (isset($_GET['id'])) {
    $flightNumber = $_GET['id'];
    
    // Fetch flight details
    $flight = fGetBaseObject('Vlucht', 'vluchtnummer', $_GET['id']);
    $luchthaven = fGetBaseObject('Luchthaven', 'luchthavencode', $flight["bestemming"]);
    
    //maxPassengers
    $countPassengers = fGetCount('Passagier', 'vluchtnummer', $_GET['id'], 'passagiernummer');
    
    // Fetch passengers for the flight
    $passengerSql = "SELECT * FROM Passagier WHERE 
                     (
                     naam LIKE :naam OR 
                     passagiernummer LIKE :id OR
                     stoel LIKE :stoel) AND
                     vluchtnummer = :vluchtnummer";
    $search_param = '%'.$search_term.'%';
    $passengerStmt = $conn->prepare($passengerSql);
    $passengerStmt->bindParam(':vluchtnummer', $flightNumber);
    $passengerStmt->bindParam(':naam', $search_param);
    $passengerStmt->bindParam(':id', $search_param);
    $passengerStmt->bindParam(':stoel', $search_param);
    $passengerStmt->execute();
    $passengers = $passengerStmt->fetchAll(PDO::FETCH_ASSOC);
} 
else 
{
    echo "Flight number not provided.";
    exit;
}
?>
<div class="mms-center">
	<div class="form-container">
    	<h2>Flight Details</h2>
    	<?php if ($flight): ?>
        <p><strong>Flight Number:</strong> <?=$flight['vluchtnummer']?></p>
        <p><strong>Destination:</strong> <?=$flight['bestemming']?> - <?=$luchthaven['naam']?></p>
        <p><strong>Gatecode:</strong> <?=$flight['gatecode']?></p>
        <p><strong>Departure Time:</strong> <?=$flight['vertrektijd']?></p>
    </div>
        
    <h3>Passengers List</h3>
    <form method="POST" action="" class="search-form">
    	<input type="text" name="search" placeholder="Search passengers" value="<?=$search_term?>">
    	<button class="submit-button" type="submit">Search</button>
	</form>
    <table border="1">
        <thead>
            <tr>
                <th>Passenger ID</th>
                <th>Name</th>
                <th>Sex</th>
                <th>Seat Number</th>
                <th>
                	<?php if ($countPassengers < $flight['max_aantal']) { ?>
                	    <a href="index.php?page=addPassenger&flight=<?=$flight['vluchtnummer']?>"><?=ADDBUTTON?></a>
                	<?php } ?> 	
                </th>
            </tr>
        </thead>
        <tbody>
            <?php if ($passengers): ?>
                <?php foreach ($passengers as $passenger): ?>
                    <tr>
                        <td><?=$passenger['passagiernummer']?></td>
                        <td><?=$passenger['naam']?></td>
                        <td><?=$passenger['geslacht']?></td>
                        <td><?=$passenger['stoel']?></td>
                        <td>
                        	<a href="index.php?page=addPassenger&flight=<?=$flight['vluchtnummer']?>&id=<?=$passenger['passagiernummer']?>"><?=EDITBUTTON?></a>
                        	<a type="submit" href="logic/deletePassenger.php?&number=<?=$passenger['passagiernummer']?>"><?=DELETEBUTTON?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No passengers found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p>Flight not found.</p>
    <?php endif; ?>
</div>