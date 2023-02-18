<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';
$db = new DB_Connect();
$conn = $db->connect();
$fun = new DB_Functions();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $start_date = $_POST["start_date"];
    $end_date = $_POST["end_date"];
    $item = $_POST["item"];
    $category = $_POST["category"];
    $location = $_POST["location"];

    $itemStr = "";
    $catStr = "";
    $locStr = "";
    if($item != "All"){
        $itemStr = "and inventory.item='".$item."'";
    }
    if($category != "All"){
        $catStr = " and category.category_name='".$category."'";
    }
    if($location != "All"){
        $locStr = " and location.location_name='".$location."'";
    }

    $response = array();
    $rows = array();

    $sql = "select inventory.id,inventory.item,category.category_name as category,location.location_name as location,unit.unit_name,avg(inventory.unit_price) as price from inventory join category on category.id = inventory.category join location on location.id = inventory.location join unit on unit.id = inventory.unit_measure where inventory.type = 'inventory' {$itemStr}{$locStr}{$catStr} group by item";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            $r = array(
                "item"=> $row["item"],
                "unit_measure"=> $row["unit_name"],
                "price"=> $row["price"],
                "beginning"=> $fun->allIn($start_date,$row["item"]) - $fun->allOut($start_date,$row["item"]),
                "purchased"=> $fun->allIn($end_date,$row["item"]) - $fun->allIn($start_date,$row["item"]),
                "consumption"=> $fun->allOut($end_date,$row["item"]) - $fun->allOut($start_date,$row["item"]),
                "siv"=> $fun->getItemSIV($start_date,$end_date,$row["item"]),
                "grn"=> $fun->getItemGrn($start_date,$end_date,$row["item"]),

            );
            array_push($rows,$r);
        }
        $response["success"] = "true";
        $response["data"] = $rows;
    }
    else{
        $response["success"] = "empty";
    }

    echo json_encode($response);

}

