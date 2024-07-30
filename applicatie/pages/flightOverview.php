<?php 
$search_term = "";
if (isset($_POST['search']))
{
    $search_term = $_POST['search'];
}

// Fetch flight information with prepared statement
$sql = "SELECT * FROM Vlucht 
        WHERE (
        vluchtnummer LIKE :nummer 
        OR bestemming LIKE :bestemming
        OR bestemming IN (SELECT luchthavencode FROM Luchthaven WHERE naam LIKE :naam)
        )
        AND vertrektijd >= GETDATE()
        ORDER BY vertrektijd";

$stmt = $conn->prepare($sql);
$search_param = '%'.$search_term.'%';
$stmt->bindParam(':nummer', $search_param);
$stmt->bindParam(':bestemming', $search_param);
$stmt->bindParam(':naam', $search_param);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<div class="mms-center">
    <h2>Flights</h2>
    
    <form method="POST" action="" class="search-form">
        <input type="text" name="search" placeholder="Search flights..." value="<?= htmlspecialchars($search_term); ?>">
        <button type="submit">Search</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Flight Number</th>
                <th>Destination</th>
                <th>Gatecode</th>
                <th>Departure time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $text = "";
            if (count($results) > 0) {
                // Output data of each row
                foreach ($results as $row) {
                    $luchthaven = fGetBaseObject('Luchthaven', 'luchthavencode', $row["bestemming"]);
                    $date = date_create($row["vertrektijd"]);
                    
                    $text .= "<tr>";
                    $text .= "<td><a href='index.php?page=flightDetails&id=".$row["vluchtnummer"]."'>".$row["vluchtnummer"]."</a></td>";
                    $text .= "<td>".$row["bestemming"]." - ".$luchthaven['naam']."</td>";
                    $text .= "<td>".$row["gatecode"]."</td>";
                    $text .= "<td>".date_format($date, "Y-m-d h:i:s")."</td>";
                    $text .= "</tr>";
                }
            } else {
                $text .= "<tr><td colspan='7'>No flights available</td></tr>";
            }
            
            echo $text;
            ?>
        </tbody>
    </table>
</div>