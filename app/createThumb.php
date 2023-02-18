<?php

include "../include/operations/DB_Functions.php";

$fun = new DB_Functions();
$_POST = json_decode(file_get_contents("php://input"),true);
$fun->createThumb("../items/images/",$_POST["image"].".jpg");

