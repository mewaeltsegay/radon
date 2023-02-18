<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/20/2020
 * Time: 10:06 PM
 */

include '../include/operations/login.php';
include '../include/operations/DB_Functions.php';

$log = new login();
$fun = new DB_Functions();

if($_SERVER["REQUEST_METHOD"] == 'POST'){

    $user = $log->getUser($_POST["uname"],$_POST["password"]);

    if($user != false){
        setcookie('uname', $user["uname"], time() + (60 * 60 * 24),'/');
        setcookie('deptid', $user["dept_id"], time() + (60 * 60 * 24),'/');
        setcookie('usertype', $fun->getRole($user["role_id"]), time() + (60 * 60 * 24),'/');
        setcookie('username', $user["user_name"], time() + (60 * 60 * 24),'/');
        setcookie('uuid', $user["uuid"], time() + (60 * 60 * 24),'/');
        header('Location:../dashboard.php');
    }
    else{
        header('location:../login.php?success=false');
    }
}