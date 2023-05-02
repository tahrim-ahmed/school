<?php
include_once '../sys/config.php';
include_once '../sys/database.php';

$query = "SELECT * FROM users";
$result = mysqli_query($link, $query);
?>