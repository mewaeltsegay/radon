<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/18/2020
 * Time: 3:22 PM
 */
if(isset($_COOKIE["uname"])){
    header('location:dashboard.php');
}
$success ="";
if(isset($_GET["success"])){
    $success = $_GET["success"];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>
        Radon - Inventory Management System by Mewael Tsegay
    </title>
    <!-- Favicon -->
    <link href="./assets/img/brand/favicon.png" rel="icon" type="image/png">
    <!-- Icons -->
    <link href="./assets/js/plugins/nucleo/css/nucleo.css" rel="stylesheet" />
    <link href="./assets/js/plugins/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet" />
    <!-- CSS Files -->
    <link href="./assets/css/argon-dashboard.css" rel="stylesheet" />
    <link href="./assets/css/login.css" rel="stylesheet" />
</head>

<body>
<div id="radon" class="card">
    <div class="card-body">
        <h1 class="card-title text-center text-darker" style="font-size: 44pt">Radon</h1>
        <h5 class="text-center mt--5">Inventory Management System</h5>
    </div>
</div>
<div class="container2" onmouseover="transin()" onmouseout="transout()">
    <div class="top2"></div>
    <div class="bottom2"></div>
    <div class="center2">
        <h2>Please Sign In</h2>
        <form method="post" action="users/processlogin.php">
            <input name="uname" type="text" placeholder="Username"/>
            <input name="password" type="password" placeholder="password"/>
            <button type="submit" class="button2 ml-7">Login</button>
        </form>
        <?php
        if($success == 'false'){
        echo '<h6 class="text-center text-danger">Wrong Username or Password.</h6>';
        }
        ?>
        <h2>&nbsp;</h2>
    </div>
</div>
<!--   Core   -->
<script src="assets/js/plugins/jquery/dist/jquery.min.js"></script>
<script src="assets/js/plugins/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!--   Optional JS   -->
<script src="assets/js/plugins/chart.js/dist/Chart.min.js"></script>
<script src="assets/js/plugins/chart.js/dist/Chart.extension.js"></script>
<script src="assets/js/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!--   Argon JS   -->
<script src="assets/js/argon-dashboard.min.js?v=1.1.0"></script>
<script src="assets/js/minion.js"></script>
</body>

</html>
