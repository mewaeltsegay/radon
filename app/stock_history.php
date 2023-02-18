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
    $loc = "";
    if(isset($_POST['location'])){
        $loc = "and location.location_name = '".$_POST["location"]."'";
    }
    $id = $_POST["id"];
    $sql = "SELECT date(created_on) as date,'Stock In' as status,'fa fa-download' as icon,'+' as sign,'text-info' as color,location.location_name,quantity FROM `transaction_in` left join location on location.id=transaction_in.location_id WHERE item_id={$id} {$loc} union SELECT date(created_on) as date,'Stock Out' as status,'fa fa-upload' as icon,'-' as sign,'text-danger' as color,location.location_name,quantity FROM `transaction_out` left join location on location.id=transaction_out.location_id WHERE item_id={$id} {$loc} union SELECT date(created_on) as date,'Stock In' as status,'fa fa-download' as icon,'+' as sign,'text-info' as color,location.location_name,quantity FROM `stock` left join location on location.id=stock.location_id where item_id = {$id} {$loc} and type='inventory' order by date desc";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) > 0){
        while ($row = mysqli_fetch_assoc($result)){
            array_push($rows,$row);
        }
        $response["success"] = "success";
        $response["data"] = $rows;
    }
    echo json_encode($response);
}
