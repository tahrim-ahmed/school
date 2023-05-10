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

$get_class = $link->query("SELECT class.*, teacher_class.*, teacher.* FROM class INNER JOIN teacher_class ON class.class_id = teacher_class.class_id INNER JOIN teacher ON teacher_class.teacher_id = teacher.teacher_id WHERE teacher.teacher_id = '$get_teacher_id'");

//add student
if (isset($_POST['first_name'])) {

// Escape user inputs for security

    $class_id = mysqli_real_escape_string($link, $_REQUEST['class_id']);
    $first_name = mysqli_real_escape_string($link, $_REQUEST['first_name']);
    $sur_name = mysqli_real_escape_string($link, $_REQUEST['sur_name']);
    $date_of_birth = mysqli_real_escape_string($link, $_REQUEST['date_of_birth']);

    $add_student_sql = "INSERT INTO student (first_name, sur_name, date_of_birth) VALUES ('$first_name', '$sur_name', '$date_of_birth')";

    if ($link->query($add_student_sql)) {
        $get_student_data = $link->query("SELECT * FROM student WHERE `first_name` = '$first_name' AND `sur_name` = '$sur_name' AND `date_of_birth` = '$date_of_birth'");
        if ($get_student_data->num_rows > 0) {
            $student_data = (object)$get_student_data->fetch_assoc();
            $get_student_id = $student_data->student_id;

            $add_student_class = "INSERT INTO student_class (class_id, student_id) VALUES ('$class_id', '$get_student_id')";

            if ($link->query($add_student_class)) {
                $add_student_record = "INSERT INTO record (student_id, attendance, result) VALUES ('$get_student_id', 0, 0)";

                if ($link->query($add_student_record)) {
                    setMessage('Added Successfully', 'success');
                    header('Location:' . $_SERVER["HTTP_REFERER"]);
                }

            }

        }
    }

}

//edit student

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


    <title><?= $_GET['class'] ?> Students</title>

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
            <button onclick="window.location.href = 'notification.php';" type="button" class="button1 px-5 fw-bold">
                Notifications
            </button>
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
    <div class="d-flex align-items-center justify-content-between px-3">
        <div class="d-flex align-items-center justify-content-center">
            <h4 class="pb-4">Student Information (<?= $_GET['class'] ?>)</h4>
        </div>
        <button class="rounded px-3 p-2 mb-3 fw-bold" type="button" data-toggle="modal"
                data-target="#modalRegisterForm">
            Add Student
        </button>
        <!--        Add Student Modal -->
        <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form class="modal-content" method="POST">
                    <div class="modal-header">
                        <h4 class="modal-title w-100 text-black font-weight-bold text-center">Add New Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3 text-black">
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="orangeForm-name">Select Class</label>
                            <select name="class_id" class="form-control" id="searchPurpose">
                                <?php
                                while ($get_class_row = $get_class->fetch_assoc()) {
                                    ?>
                                    <option
                                        value="<?= $get_class_row['class_id'] ?>"><?= $get_class_row['class_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="orangeForm-name">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control validate" required>
                        </div>
                        <div class="md-form mb-5">
                            <label data-error="wrong" data-success="right" for="orangeForm-email">Surname</label>
                            <input type="text" name="sur_name" id="sur-name" class="form-control validate" required>
                        </div>

                        <div class="md-form mb-4">
                            <label data-error="wrong" data-success="right" for="orangeForm-pass">Date of Birth</label>
                            <input type="date" name="date_of_birth" id="date-of-birth" class="form-control validate"
                                   required>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button class="button1 fw-bold">Confirm</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Student Details  -->
    <div class="d-flex align-items-center justify-content-around">
        <table id="student_data" class="table table-striped bg-light rounded p-1 ">
            <thead style="color: black">
            <tr class="px-5">
                <th class="px-5 text-center" scope="col">ID</th>
                <th class="px-5 text-center" scope="col">First Name</th>
                <th class="px-5 text-center" scope="col">Surname</th>
                <th class="px-5 text-center" scope="col">Date of Birth</th>
                <th class="px-5" scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($result)) {
                ?>
                <tr style="color: black">
                    <td class="px-5 text-center"><?= $row["student_id"] ?></td>
                    <td class="px-5 text-center"><?= $row["first_name"] ?></td>
                    <td class="px-5 text-center"><?= $row["sur_name"] ?></td>
                    <td class="px-5 text-center"><?= date('d M, Y', strtotime($row["date_of_birth"])) ?></td>
                    <td class="px-5">

                        <button class="btn btn-sm px-2 py-1 border border-success edit-button"><i
                                class="fa fa-pencil"></i></button>
                        <button class="btn btn-sm px-2 py-1 border border-danger" data-toggle="modal"
                                data-target="#delete"><i class="fa fa-trash"></i></button>


                        <!--        Edit Student Modal -->
                        <div class="modal fade" id="modalRegisterForm2" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <form class="modal-dialog" role="document" action="<?= base_url('edit/editStudent.php') ?>"
                                  method="POST">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title w-100 text-black font-weight-bold text-center">Edit
                                            Student Information</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body mx-3 text-black">
                                        <div class="md-form mb-3">
                                            <label style="text-align: left;" data-error="wrong" data-success="right"
                                                   for="id">Student ID</label>
                                            <input type="text" id="update_id" name="update_id"
                                                   class="form-control validate" required readonly>
                                        </div>
                                        <div class="md-form mb-3">
                                            <label style="text-align: left;" data-error="wrong" data-success="right"
                                                   for="name">First Name</label>
                                            <input type="text" id="update_first_name" name="update_first_name"
                                                   class="form-control validate" required>
                                        </div>
                                        <div class="md-form mb-3">
                                            <label class="level" data-success="right" for="sur-name">Surname</label>
                                            <input type="text" id="update_sur_name" name="update_sur_name"
                                                   class="form-control validate" required>
                                        </div>

                                        <div class="md-form mb-3">
                                            <label data-error="wrong" data-success="right" for="date-of-birth">Date of
                                                Birth</label>
                                            <input type="date" id="update_date_of_birth" name="update_date_of_birth"
                                                   class="form-control validate" required>
                                        </div>

                                    </div>
                                    <div class="modal-footer d-flex justify-content-center">
                                        <button class="button1 fw-bold">Confirm</button>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <!--                        Delete Student Modal -->
                        <div class="modal fade" id="delete" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title mx-auto" id="exampleModalLabel">Confirm Delete
                                            Student!</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-footer mx-auto">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button type="button" class="btn btn-danger">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
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
            dom: '<"row"<"col"><"col-auto"f>>rt<"row"<"col"i><"col-auto"l>>p',
            buttons: ['colvis',
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
                },
            ],
        });
    });

    $(document).ready(function () {
        $('.edit-button').on('click', function () {
            $('#modalRegisterForm2').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data[3]);

            $('#update_id').val(data[0]);
            $('#update_first_name').val(data[1]);
            $('#update_sur_name').val(data[2]);
            $('#update_date_of_birth').val(moment(data[3]).format('YYYY-MM-DD'));
        });
    });

    $(document).ready(function () {
        $('.close').on('click', function () {
            $('#modalRegisterForm2').modal('hide');
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