<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/8/2020
 * Time: 2:25 PM
 */

include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

$item = $_GET["item"];
$type = $_GET["type"];
$loc = "";
if(isset($_GET["loc"])){
    $loc = " and unique_id='".$_GET["loc"]."'";
}

if($_SERVER["REQUEST_METHOD"] == "GET") {
    $result1 = "";
    $sql1 = "";

    $sql1 = "SELECT unique_id FROM `inventory` WHERE item='".$item."'".$loc;
    $result1 = mysqli_query($conn, $sql1);

    if (mysqli_num_rows($result1) > 0) {
        while($row = mysqli_fetch_assoc($result1)) {
            $sql2 = "delete from `inventory transactions` where `details`='" . $row["unique_id"] . "'";
            $result2 = mysqli_query($conn,$sql2);

            if($result2 == 1){
                $sql = "delete from inventory where item='".$item."'".$loc;
                $result = mysqli_query($conn,$sql);
                if($result == 1){
                    if($type == 'Inventory') {
                        header("location:../inventory.php");
                    }
                    if($type == 'Fixed Asset'){
                        header("location:../assetDetails.php?item=".$item."&location=".$_GET["location"]);
                    }
                }
            }
        }
    }
}
