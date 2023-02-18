<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

$id = "";
$uuid = "";
$qty = "";
$type= "";
$response = array();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $uuid = $_POST["uuid"];
    $qty = $_POST["qty"];
    $created_by = $_POST["created_by"];

    $sql = "INSERT INTO `inventory transactions`(`transaction_item`, `details`,`quantity`,`returned`,`created_by`,`employee`) VALUES (" . $id . ",'" . $uuid . "'," . $qty . ",'D','" . $created_by . "',null)";
    $result = mysqli_query($conn, $sql);

    if ($result == 1) {
        $response["success"] = "true";
    } else {
        $response["success"] = "false";
    }

    echo json_encode($response);
}

