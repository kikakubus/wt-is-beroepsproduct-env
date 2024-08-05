<?php 
include_once 'logic/addPassenger.php';
?>

<div class="form-container">
    <h2>Add Passenger to Flight</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input class="mms-input" type="text" id="name" name="name" required>
        
        <label for="age">Sex:</label>
        <select class="mms-input" id="sex" name="sex" required>
        	<option>Male</option>
        	<option>Female</option>
        </select>
        
        <label for="passenger">Passenger number:</label>
        <input class="mms-input" type="number" id="passenger" name="passenger" required>
        
        <label for="seat">Seat:</label>
        <input class="mms-input" type="text" id="seat" name="seat" required>
        
        <input type="hidden" name="flightID" value="<?=$_GET['flight']?>">
        
        <button class="submit-button" type="submit">Add Passenger</button>
    </form>
</div>