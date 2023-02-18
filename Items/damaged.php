<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

$id = "";
$uuid = "";
$qty = "";
$type= "";

if(isset($_GET["id"]) && isset($_GET["uuid"]) && isset($_GET["qty"]) && isset($_GET["type"])){
    $id = $_GET["id"];
    $uuid = $_GET["uuid"];
    $qty = $_GET["qty"];
    $type = $_GET["type"];
}

$sql = "INSERT INTO `inventory transactions`(`transaction_item`, `details`,`quantity`,`returned`,`created_by`,`employee`) VALUES (".$id.",'".$uuid."',".$qty.",'D','".$_COOKIE["uuid"]."',null)";
$result = mysqli_query($conn,$sql);

if($result == 1){
    if($type == 'inventory') {
        header("location:../inventory.php");
    }
    if($type == 'fixed asset'){
        header("location:../fixedAsset.php");
    }
}

