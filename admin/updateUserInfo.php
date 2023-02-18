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
    $sql = "update users set uname='".$_POST["uname"]."',user_name='".ucwords($_POST["fname"].' '.$_POST["lname"])."',role_id=0".$fun->getRoleID($_POST["role"]).",dept_id='".$fun->getDeptID($_POST["dept"])."' where uuid='".$_POST["uuid"]."'";
    $result = mysqli_query($conn,$sql);

    header('location:../users.php');
}