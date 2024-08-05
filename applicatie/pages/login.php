<?php
include_once 'logic/login.php';
?>

<div class="form-container">
    <h2>Login</h2>
    <form action="" method="POST">
        <label for="counter">Counter number:</label>
        <input class="mms-input" type="text" id="counter" name="counter" required>
        
        <label for="password">Password:</label>
        <input class="mms-input" type="password" id="password" name="password" required>
        
        <button class="submit-button" type="submit">Login</button>
    </form>
</div>