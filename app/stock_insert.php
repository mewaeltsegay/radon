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
    $fields = "(".implode(",",$_POST["fields"]).")";
    $rows = $_POST["rows"];
    $values = implode(",",array_map(function($a) {return "(".implode(",",$a).")";},$rows));

    $sql = "insert into {$_POST['table']}{$fields} values {$values}";
    $result = mysqli_query($conn,$sql);

    if($result == 1){
        $response["success"] = "success";
    }
    else{
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
