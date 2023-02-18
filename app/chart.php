<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $items = $in_stock = $target = $reorder = $response = [];
//    $sql = "select item,target_stock_level,reorder_level,sum(quantity) as in_stock from inventory
//                where not EXISTS(select * from `inventory transactions` where details = inventory.unique_id and (returned='D' or returned='P'))
//                group by inventory.item ORDER BY RAND() limit 10";
    $sql = "select items.item,items.target_stock_level,items.reorder_level,
       (IF(NOT EXISTS(select stock.item_id from stock where stock.item_id = items.id and stock.type='inventory' group by stock.item_id),0,(select sum(stock.quantity) from stock where stock.item_id = items.id and stock.type='inventory' group by stock.item_id)) + IF(NOT EXISTS(select transaction_in.item_id from transaction_in where transaction_in.item_id = items.id group by transaction_in.item_id),0,(select sum(transaction_in.quantity) from transaction_in where transaction_in.item_id = items.id group by transaction_in.item_id))) - IF(NOT EXISTS(select transaction_out.item_id from transaction_out where transaction_out.item_id = items.id group by transaction_out.item_id),0,(select sum(transaction_out.quantity) from transaction_out where transaction_out.item_id = items.id group by transaction_out.item_id)) as in_stock from items
               group by items.id ORDER BY RAND() limit 10";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        $response["success"] = "true";
        while($row = mysqli_fetch_assoc($result)){
            array_push($items,$row["item"]);
            array_push($target,number_format($row["target_stock_level"]));
            array_push($reorder,number_format($row["reorder_level"]));
            array_push($in_stock,number_format($row["in_stock"]));
        }
        $response["items"] = $items;
        $response["target_stock_level"] = $target;
        $response["reorder_level"] = $reorder;
        $response["in_stock"] = $in_stock;
    }
    else{
        $response["success"] = "false";
        $response["items"] = [];
        $response["target_stock_level"] = [];
        $response["reorder_level"] = [];
        $response["in_stock"] = [];
    }

    echo json_encode($response);
}
