<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();
$columns = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $sql = "delete from `inventory transactions` where details='".$_POST['id']."'";

    if(mysqli_query($conn,$sql) == 1){
        $sql2 = "delete from inventory where unique_id='{$_POST['id']}'";
        if(mysqli_query($conn,$sql2) == 1)
            $response['success'] = "true";
        else
            $response['success'] = "false";
    }
    else{
        $response['success'] = "false";
    }
    echo json_encode($response);

}

