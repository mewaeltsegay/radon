<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "select items.item,unit.unit_name,items.picture,(ifnull(stock.quantity,0) + ifnull(trans_in.quantity,0) - ifnull(trans_out.quantity,0)) as qty,items.reorder_level,'Running Out' as status from items 
                left join (select item_id,ifnull(sum(quantity),0) as quantity from transaction_in group by item_id) trans_in on trans_in.item_id = items.id
                left join (select item_id,ifnull(sum(quantity),0) as quantity from transaction_out group by item_id) trans_out on trans_out.item_id = items.id
                left join (select item_id,ifnull(sum(quantity),0) as quantity from stock where type = 'inventory' group by item_id) stock on stock.item_id = items.id
                join unit on unit.id = items.unit_measure
            where (ifnull(stock.quantity,0) + ifnull(trans_in.quantity,0) - ifnull(trans_out.quantity,0)) <= items.reorder_level";
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
