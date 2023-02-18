<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';
$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

$sql = "";
$response = array();
$rows = array();


if($_SERVER['REQUEST_METHOD'] == "POST"){
//    $fields = "(".implode(",",$_POST["fields"]).")";
//    $rows = $_POST["rows"];
//    $values = implode(",",array_map(function($a) {return "(".implode(",",$a).")";},$rows));
//
//    $sql = "insert ignore into {$_POST['table']}{$fields} values {$values}";
//    $result = mysqli_query($conn,$sql);
//
//    if($result == 1){
//        $response["success"] = "success";
//    }
//    else{
//        $response["success"] = "false";
//        $response["message"] = mysqli_error($conn);
//    }
//
//    echo json_encode($response);

    $fields = "(".implode(",",$_POST["fields"]).")";
    $rows = $_POST["rows"];
    $values = implode(",",array_map(function($a) {return "(".implode(",",$a).")";},$rows));
    $res = array();
    if($_POST["type"] == "Inventory"){
        $sql = "insert ignore into {$_POST['table']}{$fields} values {$values};";
        $sql .= "insert ignore into category (category_name, created_by)
                select distinct category,created_by from tmp_inventory_items;";
        $sql .= "insert ignore into location (location_name, created_by) 
                select distinct location,created_by from tmp_inventory_items;";
        $sql .= "insert ignore into items (item,category_id,reorder_level,target_stock_level,unit_measure,expiry_date,description,unique_id,created_by)
            select tmp_inventory_items.item,category.id,tmp_inventory_items.reorder_level,tmp_inventory_items.target_stock_level,unit.id,tmp_inventory_items.expiry_date,tmp_inventory_items.description,tmp_inventory_items.unique_id,tmp_inventory_items.created_by from tmp_inventory_items
                left join category on category.category_name = tmp_inventory_items.category
                left join unit on unit.unit_name = tmp_inventory_items.unit_measure;
             ";
        $sql .= "insert into stock (item_id, location_id, quantity, unit_price, type, created_by)
                select items.id,location.id,tmp_inventory_items.quantity,tmp_inventory_items.unit_price,tmp_inventory_items.type,tmp_inventory_items.created_by from tmp_inventory_items
                    left join items on items.item = tmp_inventory_items.item
                    left join location on location.location_name = tmp_inventory_items.location
             ;";
        $sql .= "delete from tmp_inventory_items where 1;";

        if (mysqli_multi_query($conn, $sql)) {
            $response["success"] = "success";
        } else {
            $response["success"] = "failure";
            $response["message"] = mysqli_error($conn);
        }
    }
    else{
        $sql = "insert ignore into {$_POST['table']}{$fields} values {$values};";
        $sql .= "insert ignore into category (category_name, created_by)
                select distinct category,created_by from tmp_inventory_items;";
        $sql .= "insert ignore into location (location_name, created_by) 
                select distinct location,created_by from tmp_inventory_items;";
        $sql .= "insert ignore into departments (name,created_by)
                 select distinct department,created_by from tmp_inventory_items;";
        $sql .= "insert ignore into employees (first_name,last_name,department,created_by)
                select distinct substring_index(tmp_inventory_items.assigned_to,' ',1),substring_index(tmp_inventory_items.assigned_to,' ',-1),departments.id,tmp_inventory_items.created_by from tmp_inventory_items
                    left join departments on tmp_inventory_items.department = departments.name;";
        $sql .= "insert ignore into items (item,category_id,reorder_level,target_stock_level,unit_measure,expiry_date,description,unique_id,created_by)
            select tmp_inventory_items.item,category.id,tmp_inventory_items.reorder_level,tmp_inventory_items.target_stock_level,unit.id,tmp_inventory_items.expiry_date,tmp_inventory_items.description,tmp_inventory_items.unique_id,tmp_inventory_items.created_by from tmp_inventory_items
                left join category on category.category_name = tmp_inventory_items.category
                left join unit on unit.unit_name = tmp_inventory_items.unit_measure;
             ";
        $sql .= "insert into stock (item_id, location_id, quantity, unit_price, type,assigned_to, created_by)
                select items.id,location.id,tmp_inventory_items.quantity,tmp_inventory_items.unit_price,tmp_inventory_items.type,employees.id,tmp_inventory_items.created_by from tmp_inventory_items
                    left join items on items.item = tmp_inventory_items.item
                    left join location on location.location_name = tmp_inventory_items.location
                    left join employees on tmp_inventory_items.assigned_to = concat(employees.first_name,' ',employees.last_name)
             ;";
        $sql .= "delete from tmp_inventory_items where 1;";

        if (mysqli_multi_query($conn, $sql)) {
            $response["success"] = "success";
        } else {
            $response["success"] = "failure";
            $response["message"] = mysqli_error($conn);
        }
    }


    echo json_encode($response);
}
