<?php
include_once 'logic/login.php';
?>

<div class="form-container">
    <h2>Login</h2>
    <form action="" method="POST">
        <label for="counter">Counter number:</label>
        <input type="text" id="counter" name="counter" required>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
    </form>
</div>