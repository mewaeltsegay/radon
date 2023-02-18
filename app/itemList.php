<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST["id"]))
        $sql = "select items.id,items.picture,items.item,category.category_name,items.description,items.manufacturer,items.model,items.supplier,items.target_stock_level,items.reorder_level,items.serial_no, unit.unit_name,items.picture,stock.stock,group_concat(price.quantity) as price_quantity,group_concat(price.unit_price) as price_unit_price,transaction_in.trans_in as `IN`,transaction_out.trans_out as `OUT`, (IF(NOT EXISTS(select stock.item_id from stock where stock.item_id = items.id and stock.type='inventory' group by stock.item_id),0,(select sum(stock.quantity) from stock where stock.item_id = items.id and stock.type='inventory' group by stock.item_id)) + IF(NOT EXISTS(select transaction_in.item_id from transaction_in where transaction_in.item_id = items.id group by transaction_in.item_id),0,(select sum(transaction_in.quantity) from transaction_in where transaction_in.item_id = items.id group by transaction_in.item_id))) - IF(NOT EXISTS(select transaction_out.item_id from transaction_out where transaction_out.item_id = items.id group by transaction_out.item_id),0,(select sum(transaction_out.quantity) from transaction_out where transaction_out.item_id = items.id group by transaction_out.item_id)) as total from items left join (SELECT stock.item_id,GROUP_CONCAT(location.location_name,':',stock.quantity) as stock,avg(stock.unit_price) as unit_price FROM `stock` left join location on location.id = stock.location_id where stock.type='inventory' group by stock.item_id) stock on stock.item_id = items.id left join (SELECT transaction_in.item_id,GROUP_CONCAT(location.location_name,':',quantity) as trans_in,avg(unit_price) as unit_price FROM `transaction_in` left join location on location.id = transaction_in.location_id group by transaction_in.item_id) transaction_in on transaction_in.item_id =items.id left join (SELECT transaction_out.item_id,GROUP_CONCAT(location.location_name,':',quantity) as trans_out FROM `transaction_out` left join location on location.id = transaction_out.location_id group by transaction_out.item_id) transaction_out on transaction_out.item_id =items.id 
            left join(
                SELECT item_id,quantity,unit_price FROM stock WHERE type='inventory' and unit_price != 0
                UNION
                SELECT item_id,quantity,unit_price from transaction_in where unit_price != 0
            ) price on price.item_id = items.id join unit on unit.id = items.unit_measure left join category on category.id = items.category_id where items.id = {$_POST['id']}  group by items.id";
    else
        $sql = "select items.picture,items.id,items.item,category.category_name,items.picture,stock.stock,group_concat(price.quantity) as price_quantity,group_concat(price.unit_price) as price_unit_price,transaction_in.trans_in as `IN`,transaction_out.trans_out as `OUT`, (IF(NOT EXISTS(select stock.item_id from stock where stock.item_id = items.id and stock.type='inventory' group by stock.item_id),0,(select sum(stock.quantity) from stock where stock.item_id = items.id and stock.type='inventory' group by stock.item_id)) + IF(NOT EXISTS(select transaction_in.item_id from transaction_in where transaction_in.item_id = items.id group by transaction_in.item_id),0,(select sum(transaction_in.quantity) from transaction_in where transaction_in.item_id = items.id group by transaction_in.item_id))) - IF(NOT EXISTS(select transaction_out.item_id from transaction_out where transaction_out.item_id = items.id group by transaction_out.item_id),0,(select sum(transaction_out.quantity) from transaction_out where transaction_out.item_id = items.id group by transaction_out.item_id)) as total from items left join (SELECT stock.item_id,GROUP_CONCAT(location.location_name,':',stock.quantity) as stock,avg(stock.unit_price) as unit_price FROM `stock` left join location on location.id = stock.location_id where stock.type='inventory' group by stock.item_id) stock on stock.item_id = items.id left join (SELECT transaction_in.item_id,GROUP_CONCAT(location.location_name,':',quantity) as trans_in,avg(unit_price) as unit_price FROM `transaction_in` left join location on location.id = transaction_in.location_id group by transaction_in.item_id) transaction_in on transaction_in.item_id =items.id left join (SELECT transaction_out.item_id,GROUP_CONCAT(location.location_name,':',quantity) as trans_out FROM `transaction_out` left join location on location.id = transaction_out.location_id group by transaction_out.item_id) transaction_out on transaction_out.item_id =items.id left join category on items.category_id = category.id left join(
                SELECT item_id,quantity,unit_price FROM stock WHERE type='inventory' and unit_price != 0
                UNION
                SELECT item_id,quantity,unit_price from transaction_in where unit_price != 0
            ) price on price.item_id = items.id group by items.id";
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
