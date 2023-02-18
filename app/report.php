<?php
include '../include/operations/DB_Connect.php';
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
    $items = "";
    $location = "";
    $category = "";
    if($_POST["item"] != "items_all"){
        $items = "and items.id=".$_POST["item"];
    }
    if($_POST["location"] != "location_all"){
        $location = "and location_id=".$_POST["location"];
    }
    if($_POST["category"] != "category_all"){
        $category = "and category_id=".$_POST["category"];
    }

    $sql = "select items.item,unit.unit_name,group_concat(price.quantity) as price_quantity,group_concat(price.unit_price) as price_unit_price,(ifnull(stock_before.quantity,0)+ifnull(transaction_in_before.quantity,0))-ifnull(transaction_out_before.quantity,0) as beginning,ifnull(transaction_in.quantity,0) + ifnull(stock.quantity,0) as `IN`,ifnull(transaction_out.quantity,0) as `OUT`, ifnull(transaction_in.grn,'') as grn,ifnull(transaction_out.siv,'') as siv from items 
            left join stock stock1 on stock1.item_id = items.id
            left join 
                (SELECT stock.item_id, sum(stock.quantity) as quantity, avg(stock.unit_price) as unit_price FROM `stock` 
                    left join 
                    location on location.id = stock.location_id where stock.type='inventory' and date(stock.created_on) < '{$_POST['start_date']}' {$location} group by stock.item_id
                ) stock_before on stock_before.item_id = items.id 
            left join 
                (SELECT transaction_out.item_id,sum(quantity) as quantity FROM `transaction_out` 
                    left join 
                    location on location.id = transaction_out.location_id where date(transaction_out.created_on) < '{$_POST['start_date']}' {$location} group by transaction_out.item_id
                ) transaction_out_before on transaction_out_before.item_id =items.id
            left join 
                (SELECT transaction_in.item_id,sum(quantity) as quantity FROM `transaction_in` 
                    left join 
                    location on location.id = transaction_in.location_id where date(transaction_in.created_on) < '{$_POST['start_date']}' {$location} group by transaction_in.item_id
                ) transaction_in_before on transaction_in_before.item_id =items.id
            left join 
                (SELECT transaction_out.item_id,sum(quantity) as quantity,group_concat(if(siv_no != 0, siv_no,null)) as siv FROM `transaction_out` 
                    left join 
                    location on location.id = transaction_out.location_id where date(transaction_out.created_on) BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}' {$location} group by transaction_out.item_id
                ) transaction_out on transaction_out.item_id =items.id 
            left join 
                (SELECT stock.item_id, sum(stock.quantity) as quantity,sum(stock.unit_price) as total_price FROM `stock` 
                    left join 
                    location on location.id = stock.location_id where stock.type='inventory' and date(stock.created_on) BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}' {$location} group by stock.item_id
                ) stock on stock.item_id = items.id 
            left join 
                (SELECT transaction_in.item_id,sum(quantity) as quantity,group_concat(if(grn_no != 0,grn_no,null)) as grn,sum(transaction_in.unit_price) as total_price FROM `transaction_in` 
                    left join 
                    location on location.id = transaction_in.location_id where date(transaction_in.created_on) BETWEEN '{$_POST['start_date']}' and '{$_POST['end_date']}' {$location} group by transaction_in.item_id
                ) transaction_in on transaction_in.item_id =items.id 
            left join(
                SELECT item_id,quantity,unit_price FROM stock WHERE type='inventory'
                UNION
                SELECT item_id,quantity,unit_price from transaction_in
            ) price on price.item_id = items.id
            join unit on unit.id = items.unit_measure where 1 {$items} {$category} group by items.id";
    $result  = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($rows,$row);
        }
        $response["success"] = "success";
        $response["data"] = $rows;
    }
    else{
        $response["success"] = "empty";
    }

    echo json_encode($response);
}
