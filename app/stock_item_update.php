<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();
$sql = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST["table"];
    $fields = $_POST["fields"];
    $id = $_POST["id"];

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

    $sql = "UPDATE {$table} SET {$set} where id = {$id}";


    if (mysqli_query($conn, $sql) != 1) {
        $response["success"] = "false";
    } else {
        $response["success"] = "true";
    }

    echo json_encode($response);


}
