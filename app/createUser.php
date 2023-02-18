<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/4/2020
 * Time: 11:42 PM
 */

include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';
include '../include/operations/login.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();
$log = new login();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST["fname"]." ".$_POST["lname"];

    $res = $log->createUserApp($_POST["uname"],$username,$_POST["role"],$_POST["password"],$_POST["dept"],$_POST["created_by"]);

    echo json_encode($res);
}
