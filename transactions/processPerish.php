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
    $sql = "UPDATE `inventory transactions` SET `returned`='P',`return_date`='" . date("Y-m-d H:i:s") . "' WHERE id=" . $_POST["perish"];
    $result = mysqli_query($conn, $sql);

    header('location:../transactions.php');
}
