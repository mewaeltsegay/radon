<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "select group_concat(price.quantity) as price_quantity,group_concat(price.unit_price) as price_unit_price from items 
            left join(
                SELECT item_id,quantity,unit_price FROM stock WHERE type='inventory' and unit_price != 0
                UNION
                SELECT item_id,quantity,unit_price from transaction_in where unit_price != 0
            ) price on price.item_id = items.id where items.id = {$_POST['id']}  group by items.id";
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
