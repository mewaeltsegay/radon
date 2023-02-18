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
    $sql = "INSERT INTO `category`(`category_name`, `code`,`created_by`) VALUES ('".ucwords($_POST["category"])."','".$_POST["code"]."','".$_COOKIE["uuid"]."')";
    $result = mysqli_query($conn,$sql);

    if($result == 1){
        header('location:../categories.php');
    }
    else{
        header('location:../categories.php');
    }
}