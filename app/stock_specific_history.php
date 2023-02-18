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
   $fields = implode(',',$_POST["fields"]);
   $table = $_POST["table"];
   $dept = "";
   if($table == "transaction_out"){
       $dept = "left join departments on departments.id = {$table}.dept_id";
   }
   $document = $_POST["document"];

   $sql =  "select {$fields} from {$table} left join items on items.id = {$table}.item_id left join stock on stock.item_id = {$table}.item_id left join location on ${table}.location_id = location.id left join unit on unit.id = items.unit_measure {$dept} where {$table}.{$document} group by {$table}.item_id";
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
