<?php
//include_once '../sys/config.php';
//include_once '../sys/database.php';
//
//$query = "SELECT * FROM users";
//$result = mysqli_query($link, $query);
//
//dnd($result);
//?>

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
<section class="container-fluid">
    <div class="bkg mx-auto w-75 pt-3 mt-5 ">
        <div class="padding-left-5 p-4 d-flex justify-content-between" >
            <button onclick="window.location.href = 'index.php';" type="button " class="button1 px-5 py-1 fw-bold">Home</button>
            <button type="button" class="button1 px-5 fw-bold">View Students</button>
            <button type="button" class="button1 px-5 fw-bold">Notifications</button>
            <button type="button" class="button1 px-5 fw-bold">Settings</button>
        </div>
    </div>
</section>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</body>

</html>
