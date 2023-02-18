<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';
$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    array_push($_POST["items"]["fields"],"unique_id");
    array_push($_POST["stock"]["fields"],"item_id");
    $_POST["items"]["values"]["unique_id"] = "'".$fun->generateFixedAssetID()."'";
    $_POST["stock"]["values"]["item_id"] = "LAST_INSERT_ID()";
    $stock_fields = "(".implode(",",$_POST["stock"]["fields"]).")";
    $items_fields = "(".implode(",",$_POST["items"]["fields"]).")";
    $items_values = "(".implode(",",$_POST["items"]["values"]).")";
    $stock_values = "(".implode(",",$_POST["stock"]["values"]).")";

//    $values = implode(",",array_map(function($a) {return "(".implode(",",$a).")";},$rows));

    $sql = "insert into {$_POST['items']['table']}{$items_fields} values {$items_values};";
    $sql .= "insert into {$_POST['stock']['table']}{$stock_fields} values {$stock_values};";
//    $result = mysqli_query($conn,$sql);
//
    if(mysqli_multi_query($conn,$sql)){
        $response["success"] = "success";
    }
    else{
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
