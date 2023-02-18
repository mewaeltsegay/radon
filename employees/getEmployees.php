<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 6/14/2020
 * Time: 2:29 PM
 */

include "../include/operations/DB_Connect.php";
include "../include/operations/DB_Functions.php";

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

$sql = 'select CONCAT(first_name," ",last_name) AS name from employees WHERE 1';
$result = mysqli_query($conn,$sql);

$arr = array();
$arr1 = array();
if(mysqli_num_rows($result) > 0){
    while ($row = mysqli_fetch_assoc($result)){
        $arr["name"] = $row["name"];
        array_push($arr1,$arr);
    }
}
$arr2["content"] = $arr1;

echo json_encode($arr2);
