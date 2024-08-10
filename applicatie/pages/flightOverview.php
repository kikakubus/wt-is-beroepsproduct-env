<?php
$search_term = "";
if (isset($_POST['search']))
{
    $search_term = $_POST['search'];
}

$sortBy = "vertrektijd";
$sortDate = "selected";
$sortDestination = "";
if (isset($_POST['search']))
{
    $sortBy = $_POST['sort'];
    if ($sortBy == "naam") {
        $sortDate = "";
        $sortDestination = "selected";
    }
}

// Fetch flight information with prepared statement
$sql = "SELECT * FROM Vlucht 
        INNER JOIN Luchthaven ON Vlucht.bestemming = Luchthaven.luchthavencode
        WHERE (
        vluchtnummer LIKE :nummer 
        OR bestemming LIKE :bestemming
        OR Luchthaven.naam LIKE :naam
        )
        AND vertrektijd >= GETDATE()
        ORDER BY ".$sortBy."";

$stmt = $conn->prepare($sql);
$search_param = '%'.$search_term.'%';
$stmt->bindParam(':nummer', $search_param);
$stmt->bindParam(':bestemming', $search_param);
$stmt->bindParam(':naam', $search_param);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

$addFlightButton = "&nbsp;";
if(isset($_SESSION['loggedIn'])) {
    $addFlightButton = "<a href='index.php?page=addFlight'>".ADDBUTTON."</a>";
}
?>

<div class="mms-center">
    <h2>Flights</h2>
    
    <form method="POST" action="" class="search-form">
        <p1>Sort by</p1>
        <select class="mms-input" name="sort">
            <option <?=$sortDate?> value="vertrektijd">Date</option>
            <option <?=$sortDestination?> value="naam">Destination</option>
        </select>
        <p1>Search</p1>
        <input type="text" name="search" placeholder="Search flights..." value="<?=htmlspecialchars($search_term);?>">
        <button class="submit-button" type="submit">Search / Sort</button>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Flight Number</th>
                <th>Destination</th>
                <th>Gatecode</th>
                <th>Departure time</th>
                <th><?=$addFlightButton?></th>
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
                    $text .= "<td>&nbsp;</td>";
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