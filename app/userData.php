<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "select users.uname,users.user_name as full_name,roles.name as role,departments.name as department from users left join roles on roles.id = users.role_id left join departments on departments.id = users.dept_id where uuid = '{$_POST["uuid"]}'";
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
        $response["message"] = mysqli_error($conn);
    }

    echo json_encode($response);
}
