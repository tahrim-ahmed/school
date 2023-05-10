<?php
include_once '../sys/config.php';
include_once '../sys/database.php';

if($_SERVER['REQUEST_METHOD'] == "POST") {
	
    $update_id = $_REQUEST['update_id'];
    $update_attendance = $_REQUEST['update_attendance'];
    $update_result = $_REQUEST['update_result'];

    $update_record_sql = "UPDATE record SET attendance = '$update_attendance', result = '$update_result' WHERE student_id = '$update_id'";

    if ($link->query($update_record_sql)) {

        setMessage('Update Successful', 'success');
        header('Location:' . $_SERVER["HTTP_REFERER"]);
    }
    else {
        header('Location: ' . base_url('dashboard.php'));
    }
}
?>