<?php
include_once 'logic/checkin.php';
?>

<div class="form-container">
    <h2>Flight check-in</h2>
    <form action="" method="POST">
        <label for="flight">Flight number:</label>
        <input class="mms-input" type="number" id="flight" name="flight" required>
        
        <label for="passenger">Passenger number:</label>
        <input class="mms-input" type="number" id="passenger" name="passenger" required>
        
        <button class="submit-button" type="submit">Check-in</button>
    </form>
</div>