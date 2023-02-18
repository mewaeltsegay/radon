<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();

$response = array();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if($_POST["type"] == "fixed asset") {
        $item = $_POST['item'];
        $location = $_POST['location'];
        $assigned_to = explode(' ',$_POST['assigned_to']);

        $sql = "select items.item,items.picture,items.manufacturer,items.model,items.serial_no,location.location_name,category.category_name,avg(stock.unit_price) as unit_price,sum(stock.quantity) as quantity,unit.unit_name,concat(employees.first_name,' ',employees.last_name) as assigned_to from stock 
                    left join items on stock.item_id = items.id 
                    left join location on stock.location_id = location.id 
                    left join category on items.category_id = category.id 
                    left join unit on items.unit_measure = unit.id 
                    left join employees on stock.assigned_to = employees.id 
                where stock.type='fixed asset' and items.item = '{$item}' and location.location_name = '{$location}' and (employees.first_name = '{$assigned_to[0]}' and employees.last_name = '{$assigned_to[1]}') group by assigned_to,location_name,category_name";
    }
    $result = mysqli_query($conn,$sql);

    $rowArray = array();
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_assoc($result)){
            array_push($rowArray,$row);
        }
        $response["success"] = "true";
        $response["data"] = $rowArray;
    }
    else{
        $response["success"] = "false";
        $response["message"] = mysqli_error($conn);
    }
    echo json_encode($response);
}
