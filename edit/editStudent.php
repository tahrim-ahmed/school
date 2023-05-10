<?php
include_once '../sys/config.php';
include_once '../sys/database.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
	
    $update_id = $_REQUEST['update_id'];
    $update_first_name = $_REQUEST['update_first_name'];
    $update_sur_name = $_REQUEST['update_sur_name'];
    $update_date_of_birth = $_REQUEST['update_date_of_birth'];

    $update_student_sql = "UPDATE student SET first_name = '$update_first_name', sur_name = '$update_sur_name', date_of_birth = 'update_date_of_birth' WHERE student_id = '$update_id'";

    if ($link->query($update_student_sql)) {

        setMessage('Update Successful', 'success');
        header('Location:' . $_SERVER["HTTP_REFERER"]);
    }
    else {
        header('Location: ' . base_url('dashboard.php'));
    }
}
?>