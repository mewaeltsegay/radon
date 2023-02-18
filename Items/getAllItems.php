<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/9/2020
 * Time: 9:49 PM
 */

include "../include/operations/DB_Connect.php";

$db = new DB_Connect();
$conn = $db->connect();

$sql = "select DISTINCT item from inventory";
$result = mysqli_query($conn,$sql);

$myobj = array();
if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        array_push($myobj,$row["item"]);
    }
}

echo json_encode($myobj);