<?php
include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';

$fun = new DB_Functions();
$db = new DB_Connect();

$conn = $db->connect();

$fun->inventoryJSON();

