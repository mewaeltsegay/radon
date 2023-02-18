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
    $response = [];
    $res = $log->changePasswordApp($_POST["id"],$_POST["password"]);

    if($res == true){
        $response["success"] = "true";
    }
    else{
        $response["success"] = "false";
    }

    echo json_encode($response);
}
