<?php
include_once '../sys/config.php';
include_once '../sys/database.php';

$query = "SELECT * FROM teacher";
$result = mysqli_query($link, $query);

dnd($result);
?>