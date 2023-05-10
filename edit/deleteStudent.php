<?php

// connect to the database
include_once '../sys/config.php';

// confirm that the 'id' variable has been set
if (isset($_GET['ID'])) {
// get the 'id' variable from the URL
    $id = $_GET['ID'];

    $delete_student_class_sql = "DELETE FROM student_class WHERE student_id = '$id'  LIMIT 1";
    if ($delete_result1 = mysqli_query($link, $delete_student_class_sql)) {
        $delete_student_record_sql = "DELETE FROM record WHERE student_id = '$id'  LIMIT 1";

        if($delete_result2 = mysqli_query($link, $delete_student_record_sql)) {
            $delete_student_sql = "DELETE FROM student WHERE student_id = '$id'  LIMIT 1";

            if($delete_result3 = mysqli_query($link, $delete_student_sql)) {
                setMessage('Delete Success', 'success');
            }
        }

    }else{
        setMessage('Delete Unsuccessful', 'danger');
    }

} else{
    setMessage('Data not found', 'danger');
}
header('Location:' . $_SERVER["HTTP_REFERER"]);
?>