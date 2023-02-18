<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/9/2020
 * Time: 10:16 PM
 */

include "../include/operations/DB_Connect.php";
include "../include/operations/DB_Functions.php";

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

//if(isset($_GET["item"])) {
    $sql = "select item,description,category,location,supplier,manufacturer,model,serial_no,reorder_level,target_stock_level,unit_price,unit_measure,sum(quantity) as quantity,expiry_date,picture,discontinued,type from inventory WHERE (not exists(select * from `inventory transactions` where details=inventory.unique_id and (returned='D' or returned='P')) and item='" . $_GET["item"] . "') group by item";
    $result = mysqli_query($conn, $sql);

    $myobj = array();
    $myobj2 = array();
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
//            $sql2 = "SELECT quantity as quant FROM `inventory` WHERE item='".$row["item"]."' and type='Inventory'";
//            $result2 = mysqli_query($conn,$sql2);
//            $total = 0;
//            if(mysqli_num_rows($result2) > 0){
//                while ($row2 = mysqli_fetch_assoc($result2)){
//                    $total = $total + $row2["quant"];
//                }
//            }
            $myobj["item"] = $row["item"];
            $myobj["description"] = $row["description"];
            $myobj["category"] = $fun->getCategory($row["category"]);
            $myobj["location"] = $fun->getLocation($row["location"]);
            $myobj["supplier"] = $row["supplier"];
            $myobj["manufacturer"] = $row["manufacturer"];
            $myobj["model"] = $row["model"];
            $myobj["serial_no"] = $row["serial_no"];
            $myobj["reorder_level"] = $row["reorder_level"];
            $myobj["target_stock_level"] = $row["target_stock_level"];
            $myobj["unit_price"] = $row["unit_price"];
            $myobj["unit_measure"] = $row["unit_measure"];
            $myobj["quantity"] = $row["quantity"];
            $myobj["expiry_date"] = $row["expiry_date"];
            $myobj["picture"] = $row["picture"];
            $myobj["discontinued"] = $row["discontinued"];
            $myobj["type"] = $row["type"];
        }
    }
    else{
        $myobj["item"] = "empty";
    }

    echo json_encode($myobj);
//}
