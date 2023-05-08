<?php
include_once 'sys/config.php';
include_once 'sys/database.php';

$name = $_GET['firstName'];

$sql = "SELECT * FROM `users` WHERE firstName LIKE '%".$name."%'";
$res = $link->query($sql);

if($res->num_rows>0){
    while ($row = $res->fetch_assoc()){
        echo $row['firstName'];
    }
}
?>