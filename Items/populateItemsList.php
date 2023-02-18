<?php
include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';
$type = $_GET["type"];

$fun = new DB_Functions();

$fun->getAllItems($type);
