<?php 
$destinations = fGetAllObjects('Luchthaven', '1', '1');
$gates = fGetAllObjects('Gate', '1', '1');
$airlines = fGetAllObjects('Maatschappij', '1', '1');
?>

<div class="form-container">
    <h2>Add Flight</h2>
    <form action="logic/addFlight.php" method="POST">
        <label for="vertrektijd">Date:</label>
        <input class="mms-input" type="datetime-local" id="vertrektijd" name="vertrektijd" value="" required>

        <label for="bestemming">Destination:</label>
        <select class="mms-input" id="bestemming" name="bestemming" required>
            <?php 
            foreach ($destinations as $destination) {
                echo "<option value='".$destination['luchthavencode']."'>".$destination['naam']."</option>";
            }
            ?>
        </select>

        <label for="gate">Gate:</label>
        <select class="mms-input" id="gate" name="gate" required>
            <?php 
            foreach ($gates as $gate) {
                echo "<option value='".$gate['gatecode']."'>".$gate['gatecode']."</option>";
            }
            ?>
        </select>

        <label for="airline">Airline:</label>
        <select class="mms-input" id="airline" name="airline" required>
            <?php 
            foreach ($airlines as $airline) {
                echo "<option value='".$airline['maatschappijcode']."'>".$airline['naam']."</option>";
            }
            ?>
        </select>

        <label for="maxPassengers">Max passengers:</label>
        <input class="mms-input" type="number" id="maxPassengers" name="maxPassengers" value="" required>

        <label for="maxWeight">Max weight total (kg):</label>
        <input class="mms-input" type="number" id="maxWeight" name="maxWeight" value="" required>

        <label for="maxWeightPP">Max weight PP (kg):</label>
        <input class="mms-input" type="number" id="maxWeightPP" name="maxWeightPP" value="" required>

        <button class="submit-button" type="submit">Save</button>
    </form>
</div>