<?php
include_once 'sys/config.php';
include_once 'sys/database.php';

$user = getUser($_SESSION['user']->id);
$user_id = $user->user_id;

$get_user_by_id = $link->query("SELECT * FROM `users` WHERE `user_id` = '$user_id'");
$get_user = (object)$get_user_by_id->fetch_assoc();
$get_teacher_id = $get_user->teacher_id;

$get_teacher_by_teacher_id = $link->query("SELECT * FROM `teacher` WHERE `teacher_id` = '$get_teacher_id'");
$get_teacher = (object)$get_teacher_by_teacher_id->fetch_assoc();

//for dropdown class in 'View Student' in top-bar
$class_query = "SELECT class.*, teacher.*, teacher_class.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$class_result = mysqli_query($link, $class_query);

//for dropdown class in 'View Record' in top-bar
$class_query2 = "SELECT class.*, teacher.*, teacher_class.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$class_result2 = mysqli_query($link, $class_query2);

$get_student_query = "SELECT record.*, student.*, student_class.*, class.*, teacher_class.*, teacher.* FROM record INNER JOIN student ON record.student_id = student.student_id INNER JOIN student_class ON student.student_id = student_class.student_id INNER JOIN class ON student_class.class_id = class.class_id INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id' AND student.student_id = '" . $_GET["ID"] . "'";
$get_student_result = $link->query($get_student_query);

if ($get_student_result->num_rows > 0) {
    $student = mysqli_fetch_array($get_student_result);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <!-- Bootstrap  -->
    <link href="property/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384/KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Edit Student Info</title>
</head>

<body>
<img src="./image/cover.jpg" id="background-img" alt="background">
<section class="container-fluid center-div-dashboard bkg w-75 text-white pb-5">

    <!-- Menu Button  -->
    <div class=" mx-auto pt-3">
        <div class="padding-left-5 p-4 d-flex justify-content-around">
            <button onclick="window.location.href = 'index.php';" type="button" class="button1 fw-bold">Home</button>
            <div class="dropdown">
                <button class="dropdown-toggle button1 fw-bold" type="button" id="dropdownMenuButton"
                        data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false">
                    View Students
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <?php
                    while ($class_row = mysqli_fetch_array($class_result)) {
                        ?>
                        <a class="dropdown-item button1 fw-bold"
                           href="<?= base_url('students.php') ?>?class=<?= $class_row["class_name"] ?>">
                            <?= $class_row["class_name"] ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <!--            <button onclick="window.location.href = 'students.php';" type="button" class="button1  fw-bold">View Students</button>-->
            <div class="dropdown">
                <button class="button1 dropdown-toggle fw-bold text-center" type="button" id="dropdownMenuButton"
                        data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false">
                    Student progression
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton1">
                    <?php
                    while ($class_row2 = mysqli_fetch_array($class_result2)) {
                        ?>
                        <a class="dropdown-item button2 fw-bold"
                           href="<?= base_url('records.php') ?>?class=<?= $class_row2["class_name"] ?>">
                            <?= $class_row2["class_name"] ?>
                        </a>
                        <?php
                    }
                    ?>
                </div>
            </div>

            <div class="dropdown">
                <button class="dropdown-toggle button1 fw-bold" type="button" id="dropdownMenuButton"
                        data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false">
                    Settings
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item button1 fw-bold"><?= $get_teacher->teacher_name ?></a>
                    <a class="dropdown-item button1 fw-bold" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message  -->
    <div class="d-flex align-items-center justify-content-center pt-2">
        <h3 class="pb-4"> Edit Student Information </h3>
    </div>

    <!-- Main Dashboard  -->
    <div class="d-flex align-items-center  justify-content-around flex-wrap">
        <form class="bg-white text-black p-4 px-5 rounded-2 w-50" method="POST" action="edit/editStudent.php">
            <div class="form-group mb-3">
                <label for="exampleInputEmail1">Student ID</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                       placeholder="" name="student_id" value="<?= $student["student_id"] ?>" readonly>
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputEmail1">First Name</label>
                <input type="text" pattern="^[a-zA-Z\s]*$" title="Please enter only alphabetical characters." class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="<?= $student["first_name"] ?>" name="first_name">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputEmail1">Surname</label>
                <input type="text" pattern="^[a-zA-Z\s]*$" title="Please enter only alphabetical characters." class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="<?= $student["sur_name"] ?>" name="sur_name">
            </div>
            <div class="form-group mb-3">
                <label for="exampleInputEmail1">Date of Birth</label>
                <input type="date" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" value="<?= $student["date_of_birth"] ?>" name="date_of_birth">
            </div>
            <button type="submit" class="button3 fw-bold">Update</button>
        </form>
    </div>
</section>

<script src="property/bootstrap/js/bootstrap.bundle.min.js"
        integrity="sha384/ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
