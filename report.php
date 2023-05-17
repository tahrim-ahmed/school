<?php
include_once 'sys/config.php';
include_once 'sys/database.php';

$user = getUser($_SESSION['user']->id);
$user_id = $user->user_id;

$get_teacher_by_user_id = $link->query("SELECT * FROM `users` WHERE `user_id` = '$user_id'");
$get_teacher = (object)$get_teacher_by_user_id->fetch_assoc();
$get_teacher_id = $get_teacher->teacher_id;

$query = "SELECT record.*, student.*, student_class.*, class.*, teacher_class.*, teacher.* FROM record INNER JOIN student ON record.student_id = student.student_id INNER JOIN student_class ON student.student_id = student_class.student_id INNER JOIN class ON student_class.class_id = class.class_id INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id' AND class.class_name = '" . $_GET["class"] . "'";
$result = mysqli_query($link, $query);

$get_teacher_by_teacher_id = $link->query("SELECT * FROM `teacher` WHERE `teacher_id` = '$get_teacher_id'");
$get_teacher = (object)$get_teacher_by_teacher_id->fetch_assoc();

$class_query = "SELECT class.*, teacher.*, teacher_class.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$class_result = mysqli_query($link, $class_query);

$class_query2 = "SELECT class.*, teacher.*, teacher_class.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'";
$class_result2 = mysqli_query($link, $class_query2);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url('property/vendors/autocomplete/style.css') ?>">
    <link rel="stylesheet" type="text/css"
          href="<?= base_url('property/vendors/datatables/dataTables.bootstrap4.min.css') ?>">
    <link rel="stylesheet" type="text/css" href="<?= base_url('property/vendors/select2/select2.min.css') ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap  -->
    <link href="property/bootstrap/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384/KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">


    <title><?= $_GET['class'] ?> Report</title>

    <script src="<?= base_url('property/vendors/jquery.min.js') ?>"></script>
    <script src="<?= base_url('property/vendors/popper.min.js') ?>"></script>
    <script src="<?= base_url('property/vendors/bootstrap/js/bootstrap.min.js') ?>"></script>
    <script src="<?= base_url('property/vendors/daterangePicker/moment.min.js') ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="<?= base_url('property/vendors/daterangePicker/daterangepicker.js') ?>"></script>
    <script src="<?= base_url('property/vendors/datatables/datatables.min.js') ?>"></script>
    <script src="<?= base_url('property/vendors/select2/select2.full.min.js') ?>"></script>
    <script src="<?= base_url('property/js/scripts.js') ?>"></script>
    <script src="<?= base_url('property/vendors/bootstrap/js/jqBootstrapValidation.js') ?>"></script>
</head>

<body>
<img src="./image/cover.jpg" id="background-img">
<section class="container-fluid bkg w-75 mt-5 text-white pb-5">

    <!-- Menu Button  -->
    <div class=" mx-auto pt-3">
        <div class="padding-left-5 p-4 d-flex justify-content-around flex-wrap">
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

    <div class="d-flex align-items-center justify-content-between px-3">
        <div class="d-flex align-items-center justify-content-center">
            <h4 class="pb-4">Student Report (<?= $_GET['class'] ?>)</h4>
        </div>
    </div>

    <!-- Student Details  -->
    <div class="overflow-auto">
        <table id="student_data" class="table table-striped bg-light rounded p-1">
            <thead style="color: black">
            <tr class="">
                <th class=" text-center">▢</th>
                <th class=" text-center">Student ID</th>
                <th class=" text-center">First Name</th>
                <th class=" text-center">Surname</th>
                <th class=" text-center">Attendance</th>
                <th class=" text-center">Performance Score</th>
                <th class=" text-center">Overall Score</th>
                <th class=" text-center">Status</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td class=" text-center"
                        style="color: <?= ($row["result"]) < 40 ? 'red' : 'green' ?>;">■
                    </td>
                    <td class=" text-center"><?= $row["student_id"] ?></td>
                    <td class=" text-center"><?= $row["first_name"] ?></td>
                    <td class=" text-center"><?= $row["sur_name"] ?></td>
                    <td class=" text-center"><?= $row["attendance"] ?></td>
                    <td class=" text-center"><?= $row["result"] ?></td>
                    <td class=" text-center"><?= (int)(($row["attendance"] + $row["result"]) / 2) ?></td>
                    <td class=" text-center"><?= ($row["result"]) < 40 ? 'Underperforming' : 'Good' ?></td>
                </tr>
                <?php
            }
            ?>
            </tbody>
            <tfoot>
            <tr>

            </tr>
            </tfoot>
        </table>
    </div>
</section>

<script src="property/bootstrap/js/bootstrap.bundle.min.js"
        integrity="sha384/ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

<script>
    $(document).ready(function () {
        var Table = $('#student_data').DataTable({
            'bServerSide': false,
            'ordering': false,
            dom: '<"row"<"col"B><"col-auto"f>>rt<"row"<"col"i><"col-auto"l>>p',
            buttons: [
                {
                extend: 'collection',
                text: 'Performance',
                buttons: [
                    {
                        text: 'Underperforming',
                        action: function ( e, dt, node, config ) {
                            dt.column( -2 ).visible( ! dt.column( -2 ).visible() );
                        }
                    },
                    {
                        text: 'Good',
                        action: function ( e, dt, node, config ) {
                            dt.column( -1 ).visible( ! dt.column( -1 ).visible() );
                        }
                    }
                ]},
                {
                    extend: 'collection',
                    text: 'Export',
                    buttons: [{
                        extend: 'csv',
                        text: 'Export as Csv',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                        {
                            extend: 'excel',
                            text: 'Export as Excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'Export as PDF',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Print',
                            exportOptions: {
                                columns: ':visible'
                            }
                        }
                    ]
                }],
        });
    });
</script>

<style>
    .select2-container,
    .select2-container .select2-selection,
    .select2-container .select2-selection__rendered,
    .select2-container .select2-selection__arrow {
        height: 38px !important;
        line-height: 38px !important;
    }
</style>

</html>