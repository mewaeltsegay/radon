<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/10/2020
 * Time: 10:23 PM
 */
include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';
include '../include/operations/login.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

$login = new login();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "update departments set name='".ucwords($_POST["department"])."',description='".$_POST["description"]."',created_by='".$_COOKIE["uuid"]."' where id=".$_POST["id"];
    $result = mysqli_query($conn,$sql);

    header('location:../departments.php');
}