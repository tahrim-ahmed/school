<?php
include_once 'sys/config.php';
session_destroy();
session_start();
setMessage('Logout Successful..', 'success');
header('Location:'.base_url('index.php'));

?>