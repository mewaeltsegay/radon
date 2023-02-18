<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/2/2020
 * Time: 6:00 PM
 */
include "../include/operations/DB_Functions.php";
include '../include/operations/DB_Connect.php';
include '../include/operations/login.php';

$db = new DB_Connect();
$conn = $db->connect();

$log = new login();

$fun = new DB_Functions();


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if($log->checkPassword($_COOKIE["uname"],$_POST["old"]) == 1){
        $hash = $log->hashSSHA($_POST["new"]);
        $encpass = $hash["encrypted"];
        $salt = $hash["salt"];

        $sql = "UPDATE `users` SET `password`='".$encpass."',`salt`='".$salt."' WHERE uname='".$_COOKIE["uname"]."' and user_name='".$_COOKIE["username"]."'";
        $result = mysqli_query($conn,$sql);

        if($result == 1){
            header('location:../profile.php?pass=true');
        }
        else{
            header('location:../profile.php?pass=false');
        }
    }
    else{
        header('location:../profile.php?old=false');
    }
}