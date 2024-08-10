<?php 
include_once 'logic/addPassenger.php';
?>

<div class="form-container">
    <h2>Add Passenger to Flight</h2>
    <form action="" method="POST">
    
        <label for="flightID">Flight number:</label>
        <input class="mms-input" type="number" id="flightID" name="flightID" value="<?=$_GET['flight']?>" required>

        <label for="passenger">Passenger number:</label>
        <input class="mms-input" type="number" id="passenger" name="passenger" value="<?=$passenger?>" required>
    
        <label for="name">Name:</label>
        <input class="mms-input" type="text" id="name" name="name" value="<?=$name?>" required>
        
        <label for="age">Sex:</label>
        <select class="mms-input" id="sex" name="sex" required>
        	<option <?=$male?> value="M">Male</option>
        	<option <?=$female?> value="V">Female</option>
        	<option <?=$other?> value="x">Other</option>
        </select>
        
        <label for="seat">Seat:</label>
        <input class="mms-input" type="text" id="seat" name="seat" value="<?=$seat?>" required>
        
        <input type="hidden" name="oldFlightID" value="<?=$_GET['flight']?>">
        <input type="hidden" name="oldPassenger" value="<?=$oldPassenger?>">
        
        <button class="submit-button" type="submit">Save</button>
    </form>
</div>