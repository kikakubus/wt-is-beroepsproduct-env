<?php

if (isset($_SESSION['error'])) {
    echo "<div class='errorText warning'>".$_SESSION['error']."</div>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<div class='successText warning'>".$_SESSION['success']."</div>";
    unset($_SESSION['success']);
}

?>