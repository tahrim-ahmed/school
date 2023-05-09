<?php
include_once 'sys/config.php';
include_once 'sys/database.php';

$query = "SELECT * FROM `teacher`";
$result = mysqli_query($link, $query);


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
<img src="./image/cover.jpg" id="background-img">
<section class="container-fluid center-div-dashboard bkg w-75 text-white pb-5">

    <!-- Menu Button  -->
    <div class=" mx-auto pt-3 mt-5">
        <div class="padding-left-5 p-4 d-flex  justify-content-around">
            <button onclick="window.location.href = 'index.php';" type="button" class="button1 fw-bold">Home</button>
            <button onclick="window.location.href = 'students.php';" type="button" class="button1  fw-bold">View Students</button>
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
    <div class="d-flex align-items-center justify-content-center">
        <h3 class="pb-4">Welcome Back</h3>
    </div>

    <!-- Main Dashboard  -->
    <div class="d-flex align-items-center  justify-content-around">
        <div class="border border-white p-3 text-center">
            <h5 class="">You currently have:</h5>
            <h4 class="">3 Students</h4>
            <h5>Who are underperforming</h5>
            <button class="btn btn-outline-dark btn-lg btn-block mb-3 fw-bold" style="background-color: #ffffff; color: #142640;">View Students</button><br>
            <button onclick="window.location.href = 'records.php';" class="btn btn-outline-dark btn-lg btn-block mb-3 px-4 fw-bold" style="background-color: #ffffff; color: #142640;">View Record</button>
        </div>


        <div class="">
            <div class="h4" id="datetime"><?php echo date('l jS, F Y'); ?>
            </div>
            <div class="ps-4 p-3 border border-white text-center">
                <button class="button2 btn btn-outline-dark btn-lg btn-block mb-3 fw-bold px-5" style="background-color: #ffffff; color: #142640;">Help</button><br>
                <button class="button2 btn btn-outline-dark btn-lg btn-block mb-3 px-4 fw-bold px-4" style="background-color: #ffffff; color: #142640;">Support</button><br>
                <button class="text-small btn btn-outline-dark btn-lg btn-block mb-3 fw-bold" style="background-color: #ffffff; color: #142640;">Generate Report</button>
            </div>
        </div>

    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>