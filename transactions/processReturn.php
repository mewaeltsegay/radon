<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/14/2020
 * Time: 3:18 PM
 */

include "../include/operations/DB_Connect.php";
$db = new DB_Connect();
$conn = $db->connect();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(!isset($_POST["damaged"])) {
        $sql = "UPDATE `inventory transactions` SET `returned`='Y',`return_date`='" . date("Y-m-d H:i:s") . "',`received_by`='".$_COOKIE["uuid"]."' WHERE id=" . $_POST["return"];
    }
    else{
        $sql = "UPDATE `inventory transactions` SET `returned`='D',`return_date`='" . date("Y-m-d H:i:s") . "',`received_by`='".$_COOKIE["uuid"]."' WHERE id=" . $_POST["return"];
    }
    $result = mysqli_query($conn, $sql);

    header('location:../transactions.php');
}
