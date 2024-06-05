<?php
namespace pages;

$sql = "SELECT * FROM films WHERE id = ".$_GET['id']."";

echo $sql;
?>