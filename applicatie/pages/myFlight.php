<div class="form-container">
    <h2>My flight</h2>
    <form action="logic/myFlight.php" method="POST">
        <label for="flight">Flight number:</label>
        <input class="mms-input" type="number" id="flight" name="flight" required>

        <label for="passenger">Passenger number:</label>
        <input class="mms-input" type="number" id="passenger" name="passenger" required>

        <button class="submit-button" type="submit">Next</button>
    </form>
</div>