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
          integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Help</title>
</head>

<body>
<img src="./image/cover.jpg" id="background-img" alt="background">
<section class="container-fluid center-div-dashboard bkg w-75 text-white pb-5">

    <!-- Menu Button  -->
    <div class=" mx-auto pt-3">
        <div class="padding-left-5 p-4 d-flex  justify-content-around">
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
                <!--                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">-->
                <!--                    --><?php
                //                    while ($class_row3 = mysqli_fetch_array($class_result3)) {
                //                        ?>
                <!--                        <a class="dropdown-item button2 fw-bold"-->
                <!--                           href="--><?php //= base_url('records.php') ?><!--?class=--><?php //= $class_row3["class_name"] ?><!--">-->
                <!--                            --><?php //= $class_row3["class_name"] ?>
                <!--                        </a>-->
                <!--                        --><?php
                //                    }
                //                    ?>
                <!--                </div>-->
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
        <div class="d-flex align-items-center justify-content-center pt-5">
            <h3 class="pb-4"> Please Contact the Administrator.</h3>
        </div>

        <!-- Main Dashboard  -->
        <div class="d-flex align-items-center  justify-content-around">
        </div>
</section>

<script src="property/bootstrap/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>
