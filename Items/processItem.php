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

if($_SERVER["REQUEST_METHOD"] == "POST") {
        $image = "";
        $disc = "";
        if (isset($_POST["discontinued"])) {
            $disc = 'Y';
        } else {
            $disc = 'N';
        }
        $result1 = "";
        $sql1 = "";
        $qty = strval($_POST["quantity"]);
        if($fun->getUnitType($_POST["measure"]) == "pcs") {
            for ($i = 1; $i <= $qty; $i++) {
                if ($_FILES['image']['name'] != "" && isset($_FILES['image'])) {
                    $image = $fun->randomPicID($_POST["itemname"]);
                    copy($_FILES['image']['tmp_name'], "images/" . $image . ".jpg") or
                    header('location:../additems.php?success=false&reason=nocopy');
                }
                if($image != "") {
                    $fun->createThumb("images/", $image . ".jpg");
                }
                if(!isset($_POST["assigned_to"])) {
                    $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`, `location`, `supplier`, `manufacturer`, `model`, `serial_no`, `reorder_level`, `target_stock_level`, `picture`, `discontinued`,`unit_price`,`unit_measure`,`expiry_date`,`quantity`,`unique_id`,`type`,`grn_no`,`created_by`) VALUES ('" . ucwords(trim($_POST["itemname"])) . "','" . $_POST["description"] . "','" . $fun->getCategoryId($_POST["category"]) . "','" . $fun->getLocationId($_POST["location"]) . "','" . $_POST["supplier"] . "','" . $_POST["manufacturer"] . "','" . $_POST["model"] . "','" . $_POST["serialno"] . "'," . $_POST["reorderlevel"] . "," . $_POST["target"] . ",'" . $image . "','" . $disc . "'," . $_POST["price"] . ",'" . $fun->getUnitID($_POST["measure"]) . "','" . $_POST["expire"] . "',1,'" . $fun->createUniqueID($_POST["itemname"], $_POST["category"], $_POST["type"]) . "','" . $_POST["type"] . "','" . $_POST["grn"] . "','" . $_COOKIE["uuid"] . "')";
                }
                else{
                    $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`, `location`, `supplier`, `manufacturer`, `model`, `serial_no`, `reorder_level`, `target_stock_level`, `picture`, `discontinued`,`unit_price`,`unit_measure`,`expiry_date`,`quantity`,`unique_id`,`type`,`grn_no`,`created_by`,`assigned_to`) VALUES ('" . ucwords(trim($_POST["itemname"])) . "','" . $_POST["description"] . "','" . $fun->getCategoryId($_POST["category"]) . "','" . $fun->getLocationId($_POST["location"]) . "','" . $_POST["supplier"] . "','" . $_POST["manufacturer"] . "','" . $_POST["model"] . "','" . $_POST["serialno"] . "'," . $_POST["reorderlevel"] . "," . $_POST["target"] . ",'" . $image . "','" . $disc . "'," . $_POST["price"] . ",'" . $fun->getUnitID($_POST["measure"]) . "','" . $_POST["expire"] . "',1,'" . $fun->createUniqueID($_POST["itemname"], $_POST["category"], $_POST["type"]) . "','" . $_POST["type"] . "','" . $_POST["grn"] . "','" . $_COOKIE["uuid"] . "',".$fun->getEmployeeId($_POST["assigned_to"]).")";
                }
                $result1 = mysqli_query($conn, $sql1);
            }
            if ($result1 == 1) {
                if(isset($_POST["submitted"]) && isset($_POST["received"]) && isset($_POST["authorised"])){
                    $sql4 = "INSERT INTO `grn`(`item`, `submittedby`, `receivedby`, `authorisedby`, `grn_no`,`quantity`,`created_by`,`purchase_order`,`purchase_date`) VALUES ('".$_POST["itemname"]."',".$fun->getEmployeeId($_POST["submitted"]).",".$fun->getEmployeeId($_POST["received"]).",".$fun->getEmployeeId($_POST["authorised"]).",".$_POST["grn"].",".$_POST["quantity"].",'".$_COOKIE["uuid"]."','".$_POST["purchase"]."','".$_POST["purchase_date"]."')";
                    mysqli_query($conn,$sql4);
                }
                header('location:../additems.php?success=true');
            } else {
                header('location:../additems.php?success=false&reason=noinsert');
            }
        }
        else{
            if ($_FILES['image']['name'] != "" && isset($_FILES['image'])) {
                $image = $fun->randomPicID($_POST["itemname"]);
                copy($_FILES['image']['tmp_name'], "images/" . $image . ".jpg") or
                header('location:../additems.php?success=false&reason=nocopy');
            }
            if(!isset($_POST["assigned_to"])) {
                $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`, `location`, `supplier`, `manufacturer`, `model`, `serial_no`, `reorder_level`, `target_stock_level`, `picture`, `discontinued`,`unit_price`,`unit_measure`,`expiry_date`,`quantity`,`unique_id`,`type`,`created_by`) VALUES ('" . ucwords($_POST["itemname"]) . "','" . $_POST["description"] . "','" . $fun->getCategoryId($_POST["category"]) . "','" . $fun->getLocationId($_POST["location"]) . "','" . $_POST["supplier"] . "','" . $_POST["manufacturer"] . "','" . $_POST["model"] . "','" . $_POST["serialno"] . "'," . $_POST["reorderlevel"] . "," . $_POST["target"] . ",'" . $image . "','" . $disc . "'," . $_POST["price"] . ",'" . $fun->getUnitID($_POST["measure"]) . "','" . $_POST["expire"] . "'," . $_POST["quantity"] . ",'" . $fun->createUniqueID($_POST["itemname"], $_POST["category"], $_POST["type"]) . "','" . $_POST["type"] . "','" . $_COOKIE["uuid"] . "')";
            }
            else{
                $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`, `location`, `supplier`, `manufacturer`, `model`, `serial_no`, `reorder_level`, `target_stock_level`, `picture`, `discontinued`,`unit_price`,`unit_measure`,`expiry_date`,`quantity`,`unique_id`,`type`,`created_by`,`assigned_to`) VALUES ('" . ucwords($_POST["itemname"]) . "','" . $_POST["description"] . "','" . $fun->getCategoryId($_POST["category"]) . "','" . $fun->getLocationId($_POST["location"]) . "','" . $_POST["supplier"] . "','" . $_POST["manufacturer"] . "','" . $_POST["model"] . "','" . $_POST["serialno"] . "'," . $_POST["reorderlevel"] . "," . $_POST["target"] . ",'" . $image . "','" . $disc . "'," . $_POST["price"] . ",'" . $fun->getUnitID($_POST["measure"]) . "','" . $_POST["expire"] . "'," . $_POST["quantity"] . ",'" . $fun->createUniqueID($_POST["itemname"], $_POST["category"], $_POST["type"]) . "','" . $_POST["type"] . "','" . $_COOKIE["uuid"] . "',".$fun->getEmployeeId($_POST["assigned_to"]).")";
            }
            $result1 = mysqli_query($conn, $sql1);
            if($image != "") {
                $fun->createThumb("images/", $image . ".jpg");
            }

            if ($result1 == 1) {
                if(isset($_POST["submitted"]) && isset($_POST["received"]) && isset($_POST["authorised"])){
                    $sql4 = "INSERT INTO `grn`(`item`, `submittedby`, `receivedby`, `authorisedby`,`grn_no`, `quantity`,`created_by`,`purchase_order`,`purchase_date`) VALUES ('".$_POST["itemname"]."',".$fun->getEmployeeId($_POST["submitted"]).",".$fun->getEmployeeId($_POST["received"]).",".$fun->getEmployeeId($_POST["authorised"]).",".$_POST["grn"].",".$_POST["quantity"].",'".$_COOKIE["uuid"]."','".$_POST["purchase"]."','".$_POST["purchase_date"]."')";
                    mysqli_query($conn,$sql4);
                }
                header('location:../additems.php?success=true');
            } else {
                header('location:../additems.php?success=false&reason=noinsert');
            }
        }
}
