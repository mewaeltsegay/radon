<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $fields = $_POST["fields"];
    $id = $_POST["uuid"];
    $response = array();

    $set = '';
    $x = 1;

    foreach ($fields as $name => $value) {
        $set .= "{$name} = \"{$value}\"";
        if ($x < count($fields)) {
            $set .= ',';
        }
        $x++;
    }

    $sql = "UPDATE users SET {$set} where uuid = '{$id}'";

    if (mysqli_query($conn, $sql) != 1) {
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
     } else {
        $response["success"] = "success";
    }

    echo json_encode($response);
}
