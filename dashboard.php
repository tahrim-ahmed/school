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

//for dropdown class in 'View Student'
$class_query2 = "SELECT class.*, teacher.*, teacher_class.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$class_result2 = mysqli_query($link, $class_query2);

//for dropdown class in 'View Record' 
$class_query3 = "SELECT class.*, teacher.*, teacher_class.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$class_result3 = mysqli_query($link, $class_query3);

//for counting underperforming student
$count = 0;
$underperform_query = "SELECT record.*, student.*, student_class.*, class.*, teacher_class.*, teacher.* FROM record INNER JOIN student ON record.student_id = student.student_id INNER JOIN student_class ON student.student_id = student_class.student_id INNER JOIN class ON student_class.class_id = class.class_id INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$underperform_result = mysqli_query($link, $underperform_query);
while ($underperform_row = mysqli_fetch_array($underperform_result)) {
    if(($underperform_row["attendance"] + $underperform_row["result"])<40) {
        $count++;
    }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>
</head>

<body>
<img src="./image/cover.jpg" id="background-img" alt="background">
<section class="container-fluid center-div-dashboard bkg w-75 text-white pb-5">

    <!-- Menu Button  -->
    <div class=" mx-auto pt-3">
        <div class="padding-left-5 p-4 d-flex  justify-content-around">
            <button onclick="window.location.href = 'index.php';" type="button" class="button1 fw-bold">Home</button>
            <div class="dropdown">
                <button class="dropdown-toggle button1 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
                    View Students
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <?php
            while ($class_row = mysqli_fetch_array($class_result)) {
                ?>
                <a class="dropdown-item button1 fw-bold" href="<?= base_url('students.php') ?>?class=<?= $class_row["class_name"] ?>">
                                        <?= $class_row["class_name"] ?>
                </a>
                <?php
            }
            ?>
                </div>
            </div>
<!--            <button onclick="window.location.href = 'students.php';" type="button" class="button1  fw-bold">View Students</button>-->
            <button type="button" class="button1 px-5 fw-bold">Notifications</button>
            <div class="dropdown">
                <button class="dropdown-toggle button1 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
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
    <div class="d-flex align-items-center justify-content-center">
        <h3 class="pb-4">Welcome Back</h3>
    </div>

    <!-- Main Dashboard  -->
    <div class="d-flex align-items-center  justify-content-around">
        <div class="border border-white p-3 text-center">
            <h5 class="">You currently have:</h5>
            <h4 class=""><?= $count ?> <?= $count == 1 ? 'Student' : 'Students' ?> </h4>
            <h5>Who are underperforming</h5>

<!--            view students and view record button -->
            <div class="dropdown">
                <button class="dropdown-toggle rounded p-2 mb-3 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
                    View Students
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton1">
                    <?php
            while ($class_row2 = mysqli_fetch_array($class_result2)) {
                ?>
                <a class="dropdown-item button2 fw-bold" href="<?= base_url('students.php') ?>?class=<?= $class_row2["class_name"] ?>">
                                        <?= $class_row2["class_name"] ?>
                </a>
                <?php
            }
            ?>
                </div>
            </div>
<!--            <button class="btn btn-outline-dark btn-lg btn-block mb-3 fw-bold" style="background-color: #ffffff; color: #142640;">View Students</button><br>-->
            <div class="dropdown">
                <button class="dropdown-toggle rounded px-3 p-2 mb-3 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
                    View Record
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <?php
            while ($class_row3 = mysqli_fetch_array($class_result3)) {
                ?>
                <a class="dropdown-item button2 fw-bold" href="<?= base_url('records.php') ?>?class=<?= $class_row3["class_name"] ?>">
                                        <?= $class_row3["class_name"] ?>
                </a>
                <?php
            }
            ?>
                </div>
            </div>
<!--            <button onclick="window.location.href = 'records.php';" class="btn btn-outline-dark btn-lg btn-block mb-3 px-4 fw-bold" style="background-color: #ffffff; color: #142640;">View Record</button>-->
        </div>


        <div class="">
            <div class="h4" id="datetime"><?php echo date('l jS, F Y'); ?>
            </div>
            <div class="ps-4 p-3 border border-white text-center">
                <button class="button2 btn btn-outline-dark btn-lg btn-block mb-3 fw-bold px-5" style="background-color: #ffffff; color: #142640;">Help</button><br>
                <button class="button2 btn btn-outline-dark btn-lg btn-block mb-3 px-4 fw-bold px-4" style="background-color: #ffffff; color: #142640;">Support</button><br>
                <button onclick="window.location.href = 'records.php';" class="text-small btn btn-outline-dark btn-lg btn-block mb-3 fw-bold" style="background-color: #ffffff; color: #142640;">Generate Report</button>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>