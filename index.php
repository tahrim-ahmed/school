<?php

include_once 'sys/config.php';
if (isset($_SESSION['user'])) {
  $row = $_SESSION['user'];
  header('Location:' . base_url('dashboard.php'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $user_name = $_POST['user_name'];
  $password = $_POST['password'];
  $result = $link->query("SELECT * FROM `users` WHERE `user_name` = '$user_name'");
  if ($result->num_rows > 0) {
    $row = (object)$result->fetch_assoc();
    if ($password == $row->password) {
      if(!isset($_SESSION)) {
        session_start();
      }
      $_SESSION['user'] = (object)['id' => $row->user_id];
      header('Location: ' . base_url('dashboard.php'));
    } else {
      setMessage('The username or password entered is incorrect, please try again!', 'danger');
    }
  } else {
    setMessage('User not exists!', 'danger');
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap  -->
  <link href="property/bootstrap/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384/KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">

  <!-- CSS  -->
  <link rel="stylesheet" href="index.css">
  <title>Home</title>
</head>

<body>
<img src="./image/cover.jpg" id="background-img">
<section class="container-fluid center-div ">
  <div class="bg-white mx-auto w-50 pt-3 mt-5">
    <p class="font-weight  text-center display-4 m-0">Welcome</p>
    <div class="container-fluid">
      <div class="row d-flex align-items-center justify-content-center">
        <div class="col-sm-6 text-black  ">
          <div class="d-flex align-items-center justify-content-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">

            <form style="width: 23rem;" method="POST">
              <?php
                if (isset($_SESSION['message'])) {
                  $error = $_SESSION['message'];
                  ?>
                  <div id="alertBox" class="alert alert-<?= $error->type ?> text-center" style="margin: 10px;"><?= $error->text ?></div>
                  <?php
                  unset($_SESSION['message']);
                  }
              ?>
              <h3 class="fw-bold text-center pb-3" style="letter-spacing: 1px;">Sign in</h3>

              <div class="form-group ">
                <label class="form-label" for="form2Example18">User Name</label>
                <input type="text" name="user_name" id="form2Example18" class="form-control form-control-lg" />
              </div>

              <div class="form-outline mt-2">
                <label class="form-label" for="form2Example28">Password</label>
                <input type="password" name="password" id="form2Example28" class="form-control form-control-lg" />
              </div>

              <p class="small mb-2 mt-2 pb-lg-2"><a class="text-muted" href="#!">Forgot your password?</a></p>
              <div class="p-1 mb-4 d-flex justify-content-center">
                <button class="btn px-3 btn-primary" style="background-color: #142640; color: white;">Log in</button>
              </div>
            </form>
          </div>
        </div>


        <div class="col-sm-6 pl">
          <p class="fw-bold">Not registered with us?</p>
          <button class="btn btn-primary" style="background-color: #142640; color: white;">Create an Account</button>
        </div>
        <div class="row d-flex align-items-center justify-content-center">
          <div class="col-sm-12 text-black  ">
            <?php
            if (isset($_SESSION['message'])) {
              $error = $_SESSION['message'];
              ?>
              <div id="alertBox" class="alert alert-<?= $error->type ?> text-center"
                   style="margin: 10px;"><?= $error->text ?></div>
              <?php
              unset($_SESSION['message']);
            }
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script src="property/bootstrap/js/bootstrap.bundle.min.js"
        integrity="sha384/ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
</body>

</html>