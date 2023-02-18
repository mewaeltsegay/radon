<?php

include "../include/operations/DB_Connect.php";
include "../include/operations/DB_Functions.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $user = $_POST["user"];
    $pass = $_POST["pass"];

    $fun = new DB_Functions();

    $userinfo = $fun->getUserByUsernameAndPassword($user,$pass);

    $arr = array();
    $arr2 = array();

    if($userinfo == null) {
        $arr["status"] = "failure";
        $arr["message"] = "Unknown user";
        $arr2 = $arr;
    }
    else{
        $arr["status"] = "success";
        $arr["user"] = $userinfo;
        $arr["permissions"] = $fun->getUserPermissions($userinfo["uuid"]);
        $arr2 = $arr;
    }
    echo json_encode($arr2);
}
else{
    header("location:../dashboard.php");
}
