<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/6/2020
 * Time: 5:52 PM
 */
if(!isset($_COOKIE["uname"])){
    header('location:login.php');
}

    function getScriptName(){
        $fullname = explode("/",$_SERVER['SCRIPT_NAME']);

        return $fullname[count($fullname)-1];

    }
    $item2 = $loc2 = $cat2 = "";
    if(getScriptName() == "report.php"){
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            $item2 = $_POST["item"];
            $loc2 = $_POST["location"];
            $cat2 = $_POST["category"];
        }
    }
?>

<!--

=========================================================
* Argon Dashboard - v1.1.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard
* Copyright 2019 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://github.com/creativetimofficial/argon-dashboard/blob/master/LICENSE.md)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->
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
    <link href="./assets/css/argon-dashboard.css?v=1.1.0" rel="stylesheet" media="screen" />
    <link href="assets/css/damagedTiles.css" rel="stylesheet" />
    <link rel="stylesheet" media="print" href="./assets/css/print.css" />
    <script src="assets/js/plugins/jquery/dist/jquery.min.js"></script>
    <script src="assets/js/plugins/apexcharts/dist/apexcharts.js"></script>
</head>

<body class=" bg-gradient-dark"
      <?php if(getScriptName() == "report.php" and $_SERVER["REQUEST_METHOD"] == "POST") {?>
          onload = "selector('<?php echo $item2;?>','<?php echo str_replace(" ","_",$cat2);?>','<?php echo $loc2;?>')"
      <?php } ?>
>


