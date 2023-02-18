<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "select items.item,items.unique_id,location.location_name,category.category_name,'Damaged' as status from transaction_out 
              left join items on items.id = transaction_out.item_id
              left join location on transaction_out.location_id = location.id
              left join category on items.category_id = category.id
              where transaction_out.type = 'damaged'";
    $result  = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($rows,$row);
        }
        $response["success"] = "success";
        $response["data"] = $rows;
    }

    echo json_encode($response);
}
