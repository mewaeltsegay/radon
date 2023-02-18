<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();
$sql = "";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = $_POST["table"];
    $fields = $_POST["fields"];

    if(isset($_POST["id"])){
        $id = $_POST["id"];
    }
    if(isset($_POST["uid"])){
        $uid = $_POST["uid"];
    }

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

    if(isset($_POST["id"]))
        $sql = "UPDATE {$table} SET {$set} where item ='{$id}' and not exists(select * from `inventory transactions` where details={$table}.unique_id and (returned = 'D' or returned = 'P' or returned = 'Q' or returned = ''))";
    if(isset($_POST["uid"]))
        if($_POST["fields"]["type"] == "Fixed Asset")
            $sql = "UPDATE {$table} SET {$set} where unique_id ='{$uid}'";
        elseif ($_POST["fields"]["type"] == "Inventory")
            $sql = "UPDATE {$table} SET {$set} where unique_id ='{$uid}' and not exists(select * from `inventory transactions` where details={$table}.unique_id and (returned = 'D' or returned = 'P' or returned = 'Q' or returned = ''))";


    if (mysqli_query($conn, $sql) != 1) {
        $response["success"] = "false";
    } else {
        $response["success"] = "true";
    }

    echo json_encode($response);


}
