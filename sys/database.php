<?php

include_once 'config.php';
/**
 * @var $link mysqli
 */
function getUser($id){
    global $link;
    $result=$link->query("SELECT * FROM `users` WHERE `user_id`='$id'");
    return $result->num_rows>0?(object)$result->fetch_assoc():false;
}
