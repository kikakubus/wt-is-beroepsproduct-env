<?php 
include_once 'logic/addPassenger.php';
?>

<div class="form-container">
    <h2>Add Passenger to Flight</h2>
    <form action="" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        
        <label for="age">Sex:</label>
        <input type="sex" id="sex" name="sex" required>
        
        <label for="counterNumber">Passenger number:</label>
        <input type="number" id="counterNumber" name="counterNumber" required>
        
        <label for="seat">Seat:</label>
        <input type="text" id="seat" name="seat" required>
        
        <input type="hidden" name="flightID" value="<?=$_GET['flight']?>">
        
        <button type="submit">Add Passenger</button>
    </form>
</div>