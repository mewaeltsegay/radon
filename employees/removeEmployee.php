<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/8/2020
 * Time: 2:25 PM
 */

include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

$id = $_GET["id"];

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $result1 = "";
    $sql1 = "";

    $sql1 = "delete from employees where id=".$id;
    $result1 = mysqli_query($conn, $sql1);

    if($result1 == 1){
        header("location:../employees.php");
    }
}
