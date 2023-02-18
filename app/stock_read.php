<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $fields = implode(",",$_POST["fields"]);
    $table = $_POST["table"];
    $where = $_POST["where"];

    $sql = "select {$fields} from {$table} where {$where}";
    $result  = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($rows,$row);
        }
        $response["success"] = "success";
        $response["data"] = $rows;
    }
    else{
        $response["success"] = "false";
    }

    echo json_encode($response);

}
