<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/2/2020
 * Time: 6:00 PM
 */
include "../include/operations/DB_Functions.php";
include '../include/operations/DB_Connect.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_POST["fname"]." ".$_POST["lname"];
    $uname = $_POST["uname"];

    $sql = "UPDATE `users` SET `uname`='".$uname."',`user_name`='".$username."' WHERE uname='".$_COOKIE["uname"]."' and user_name='".$_COOKIE["username"]."'";
    $result = mysqli_query($conn,$sql);

    if($result == 1){
        setcookie('uname', $uname, time() + (60 * 60 * 24),'/');
        setcookie('username', $username, time() + (60 * 60 * 24),'/');
        header('location:../profile.php?success=true');
    }
    else{
        header('location:../profile.php?success=false');
    }
}