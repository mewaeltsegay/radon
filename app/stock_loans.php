<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();
$db = new DB_Connect();
$conn = $db->connect();

$sql = "";
$response = array();
$rows = array();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $sql = "select transaction_out.id,items.item,unit.unit_name,transaction_out.quantity,date(transaction_out.created_on)as date,transaction_out.remark,concat(employees.first_name,' ',employees.last_name) as employee from transaction_out
                left join items on items.id = transaction_out.item_id
                join unit on unit.id = items.unit_measure
                left join employees on transaction_out.employee_id = employees.id
            where transaction_out.type = 'Loaned'";

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
