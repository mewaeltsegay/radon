<?php

include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $rows = array();
    $sql = "select items.id,items.item,((ifnull(stock.quantity,0)+ifnull(transaction_in.quantity,0))-ifnull(transaction_out.quantity,0)) as quantity,items.category_id from items 
            left join (SELECT stock.item_id,sum(stock.quantity) as quantity FROM `stock` 
                    left join location on location.id = stock.location_id where stock.type='inventory' and location.location_name='{$_POST['location']}' group by stock.item_id
                ) stock on stock.item_id = items.id 
            left join (SELECT transaction_in.item_id,sum(quantity) as quantity FROM `transaction_in` 
                left join location on location.id = transaction_in.location_id where location.location_name='{$_POST['location']}' group by transaction_in.item_id
                ) transaction_in on transaction_in.item_id =items.id 
            left join (SELECT transaction_out.item_id,sum(quantity) as quantity FROM `transaction_out` 
                left join location on location.id = transaction_out.location_id where location.location_name='{$_POST['location']}' group by transaction_out.item_id
                ) transaction_out on transaction_out.item_id =items.id           
            group by items.id";
    $result  = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            $row["price"] = $fun->getAvgPrice($row["id"]);
            array_push($rows,$row);
        }
        $response["success"] = "success";
        $response["data"] = $rows;
    }

    echo json_encode($response);
}

