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

$prefix = "";
if(isset($_GET["item"])) {
    $prefix = "item='". $_GET["item"]."' ";
}
if (isset($_GET["id"])){
    $prefix = "unique_id='".$_GET["id"]."' ";
}
$loc = "";
if(isset($_GET["uuid"])){
    $loc = " and unique_id='".$_GET["uuid"]."'";
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $image = "";
    if ($_FILES['image']['name'] != "" && isset($_FILES['image'])) {
        $image = $fun->randomPicID($_POST["itemname"]);
        copy($_FILES['image']['tmp_name'], "images/" . $image . ".jpg");

        $fun->createThumb("images/", $image . ".jpg");
    }
    else{
        if(isset($_POST["saved"])){
            $image = $_POST["saved"];
        }
    }
    $result1 = "";
    $sql1 = "";

    if(!isset($_POST["assigned_to"])) {
        $sql1 = "UPDATE `inventory` SET `item`='" . $_POST["itemname"] . "',`description`='" . $_POST["description"] . "',`category`='" . $fun->getCategoryId($_POST["category"]) . "',`location`='" . $fun->getLocationId($_POST["location"]) . "',`manufacturer`='" . $_POST["manufacturer"] . "',`model`='" . $_POST["model"] . "',`reorder_level`=" . $_POST["reorderlevel"] . ",`target_stock_level`=" . $_POST["target"] . ",`unit_price`=" . $_POST["price"] . ",`unit_measure`=" . $fun->getUnitID($_POST["measure"]) . ",`picture`='" . $image . "',`type`='" . $_POST["type"] . "',`created_by`='" . $_COOKIE["uuid"] . "' WHERE " . $prefix . $loc;
    }
    else{
        $sql1 = "UPDATE `inventory` SET `item`='" . $_POST["itemname"] . "',`description`='" . $_POST["description"] . "',`category`='" . $fun->getCategoryId($_POST["category"]) . "',`location`='" . $fun->getLocationId($_POST["location"]) . "',`manufacturer`='" . $_POST["manufacturer"] . "',`model`='" . $_POST["model"] . "',`reorder_level`=" . $_POST["reorderlevel"] . ",`target_stock_level`=" . $_POST["target"] . ",`unit_price`=" . $_POST["price"] . ",`unit_measure`=" . $fun->getUnitID($_POST["measure"]) . ",`picture`='" . $image . "',`type`='" . $_POST["type"] . "',`created_by`='" . $_COOKIE["uuid"] . "',assigned_to=".$fun->getEmployeeId($_POST["assigned_to"])." WHERE " . $prefix . $loc;
    }
    $result1 = mysqli_query($conn, $sql1);

    if ($result1 == 1) {
        if(isset($_GET["uuid"])){
            header('location:../assetDetails.php?item='.$_POST["itemname"].'&location='.$fun->getLocationId($_POST["location"]));
        }
        else {
            header('location:../inventory.php');
        }
    }
}
