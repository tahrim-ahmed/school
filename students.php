<?php
include_once 'sys/config.php';
include_once 'sys/database.php';

$query = "SELECT * FROM student";
$result = mysqli_query($link, $query);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" type="text/css" href="<?=base_url('property/vendors/autocomplete/style.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('property/vendors/datatables/dataTables.bootstrap4.min.css')?>">
    <link rel="stylesheet" type="text/css" href="<?=base_url('property/vendors/select2/select2.min.css')?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap  -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Document</title>

    <script src="<?=base_url('property/vendors/jquery.min.js')?>"></script>
    <script src="<?=base_url('property/vendors/popper.min.js')?>"></script>
    <script src="<?=base_url('property/vendors/bootstrap/js/bootstrap.min.js')?>"></script>
    <script src="<?=base_url('property/vendors/daterangePicker/moment.min.js')?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script src="<?=base_url('property/vendors/daterangePicker/daterangepicker.js')?>"></script>
    <script src="<?=base_url('property/vendors/datatables/datatables.min.js')?>"></script>
    <script src="<?=base_url('property/vendors/select2/select2.full.min.js')?>"></script>
    <script src="<?=base_url('property/js/scripts.js')?>"></script>
    <script src="<?=base_url('property/vendors/bootstrap/js/jqBootstrapValidation.js')?>"></script>
</head>

<body>
<img src="./image/cover.jpg" id="background-img">
<section class="container-fluid bkg w-75 mt-5 text-white pb-5">

    <!-- Menu Button  -->
    <div class=" mx-auto pt-3">
        <div class="padding-left-5 p-4 d-flex justify-content-around">
            <button onclick="window.location.href = 'index.php';" type="button" class="button1 fw-bold">Home</button>
            <div class="dropdown">
                <button class="dropdown-toggle button1 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
                    View Students
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item button1 fw-bold" href="students.php">Class One</a>
                </div>
            </div>
            <!--            <button onclick="window.location.href = 'students.php';" type="button" class="button1  fw-bold">View Students</button>-->
            <button type="button" class="button1 px-5 fw-bold">Notifications</button>
            <div class="dropdown">
                <button class="dropdown-toggle button1 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
                    Settings
                </button>
                <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item button1 fw-bold" href="#">Teacher Name</a>
                    <a class="dropdown-item button1 fw-bold" href="#">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Message  -->
<div class="d-flex align-items-center justify-content-between px-3">
    <div class="d-flex align-items-center justify-content-center">
        <h4 class="pb-4">Student Information</h4>
    </div>
    <div class="dropdown">
        <button class="dropdown-toggle rounded px-3 p-2 mb-3 fw-bold" type="button" id="dropdownMenuButton" data-bs-toggle='dropdown' aria-haspopup="true" aria-expanded="false"  >
            Add Student
        </button>

<!--        Add Student Modal -->
        <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <h4 class="modal-title w-100 text-black font-weight-bold">Add New Student</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body mx-3 text-black">
                        <div class="md-form mb-5">
                            <input type="text" id="first-name" class="form-control validate" required>
                            <label data-error="wrong" data-success="right" for="orangeForm-name">First Name</label>
                        </div>
                        <div class="md-form mb-5">
                            <input type="text" id="sur-name" class="form-control validate" required>
                            <label data-error="wrong" data-success="right" for="orangeForm-email">Surname</label>
                        </div>

                        <div class="md-form mb-4">
                            <input type="date" id="date-of-birth" class="form-control validate" required>
                            <label data-error="wrong" data-success="right" for="orangeForm-pass">Date of Birth</label>
                        </div>

                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button class="button1 fw-bold">Confirm</button>
                    </div>
                </div>
            </div>
        </div>

<!--        Add student Dropdown -->
        <div class="dropdown-menu p-0" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item button1 fw-bold" data-toggle="modal" data-target="#modalRegisterForm"  href="">Class One</a>
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
                    <th class="px-5 text-center" scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $total = 0;
                while ($row = mysqli_fetch_array($result)) {
                    ?>
                    <tr style="color: black">
                        <td class="px-5 text-center"><?= $row["student_id"] ?></td>
                        <td class="px-5 text-center"><?= $row["first_name"] ?></td>
                        <td class="px-5 text-center"><?= $row["sur_name"] ?></td>
                        <td class="px-5 text-center"><?= date('d M, Y', strtotime($row["date_of_birth"])) ?></td>
                        <td class="text-center">
                            <button class="btn btn-sm px-2 py-1 border border-success"><i class="fa fa-pencil"></i></button>
                            <button class="btn btn-sm px-2 py-1 border border-danger"><i class="fa fa-trash"></i></button>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
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
                    buttons: [
                        {
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
</script>

<style>
    .select2-container, .select2-container .select2-selection, .select2-container .select2-selection__rendered, .select2-container .select2-selection__arrow {
        height: 38px !important;
        line-height: 38px !important;
    }
</style>

</html>