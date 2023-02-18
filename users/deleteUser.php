<?php
/**
 * Created by PhpStorm.
 * User: Reaper
 * Date: 11/5/2020
 * Time: 6:25 PM
 */

include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

$id = $_GET["id"];

$sql = "update users set deactivated='Y' WHERE id=".$id;
$res = mysqli_query($conn,$sql);

$arr = array();
if($res == 1 ) {
    $arr["success"] = true;
}
else{
    $arr["success"] = false;
}

echo json_encode($arr);