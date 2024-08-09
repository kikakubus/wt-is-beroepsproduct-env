<div class="form-container">
    <h2>Flight check-in</h2>
    <form action="logic/checkin.php" method="POST">
        <label for="flight">Flight number:</label>
        <input class="mms-input" type="number" id="flight" name="flight" required>

        <label for="passenger">Passenger number:</label>
        <input class="mms-input" type="number" id="passenger" name="passenger" required>

        <button class="submit-button" type="submit">Save</button>
    </form>
</div>

<div class="form-container">
    <h2>Baggage check-in</h2>
    <form action="logic/checkinBaggage.php" method="POST">
        <label for="flight">Flight number:</label>
        <input class="mms-input" type="number" id="flight" name="flight" required>

        <label for="passenger">Passenger number:</label>
        <input class="mms-input" type="number" id="passenger" name="passenger" required>
        
        <label for="weight">Weight (kg):</label>
        <input class="mms-input" type="number" id="weight" name="weight" required>

        <button class="submit-button" type="submit">Save</button>
    </form>
</div>