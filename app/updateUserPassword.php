<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $uuid = $_POST["uuid"];
    $hash = $fun->hashSSHA($_POST["password"]);


    $sql = "UPDATE users SET password='{$hash["encrypted"]}',salt='{$hash["salt"]}' where uuid = '{$uuid}'";

    if (mysqli_query($conn, $sql) != 1) {
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    } else {
        $response["success"] = "success";
    }

    echo json_encode($response);
}
