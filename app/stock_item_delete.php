<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){

    $sql = "delete from transaction_in where item_id={$_POST["id"]};";
    $sql .= "delete from transaction_out where item_id={$_POST["id"]};";
    $sql .= "delete from stock where item_id={$_POST["id"]};";
    $sql .= "delete from items where id={$_POST["id"]};";

    if(mysqli_multi_query($conn,$sql)){
        $response["success"] = "success";
    }
    else{
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
