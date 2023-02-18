<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/13/2020
 * Time: 6:07 PM
 */

include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$fun = new DB_Functions();

$db = new DB_Connect();
$conn = $db->connect();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "";
    $result = "";
    if($_POST["transaction_type"] != "Permanently Move" && $_POST["transaction_type"] != "Relocate") {
        if(count($_POST["items"]) > 1) {
            foreach ($_POST["items"] as $item) {
                $sql = "INSERT INTO `inventory transactions`(`transaction_item`,`details`, `employee`, `transaction_type`, `quantity`,`comment`,`siv`,`created_by`,`requisition`) VALUES ('" . $fun->getItemId($_POST["item"]) . "','" . $item . "','" . $fun->getEmployeeId($_POST["employee"]) . "','" . $fun->getTransactionTypeId($_POST["transaction_type"]) . "','1','" . $fun->test_input($_POST["remark"]) . "','" . $_POST["siv"] . "','" . $_COOKIE["uuid"] . "',".$_POST["requisition"].")";
                $result = mysqli_query($conn, $sql);
            }
        }
        if(count($_POST["items"]) == 1){
            foreach ($_POST["items"] as $item) {
                $sql = "INSERT INTO `inventory transactions`(`transaction_item`,`details`, `employee`, `transaction_type`, `quantity`,`comment`,`siv`,`created_by`,`requisition`) VALUES ('" . $fun->getItemId($_POST["item"]) . "','" . $item . "','" . $fun->getEmployeeId($_POST["employee"]) . "','" . $fun->getTransactionTypeId($_POST["transaction_type"]) . "','" . $_POST["quantity"] . "','" . $fun->test_input($_POST["remark"]) . "','" . $_POST["siv"] . "','" . $_COOKIE["uuid"] . "',".$_POST["requisition"].")";
                $result = mysqli_query($conn, $sql);
            }
        }
    }
    elseif ($_POST["transaction_type"] == "Relocate"){
        if(count($_POST["items"]) > 1 ){
            foreach ($_POST["items"] as $item) {
                $item = trim(explode(" ",$item)[0]);
                $sql .= "INSERT INTO `inventory transactions`(`transaction_item`,`details`, `employee`, `transaction_type`, `quantity`,`comment`,`returned`,`siv`,`created_by`,`requisition`) VALUES ('" . $fun->getItemId($_POST["item"]) . "','" . $item . "','" . $fun->getEmployeeId($_POST["employee"]) . "','" . $fun->getTransactionTypeId($_POST["transaction_type"]) . "','1','" . $fun->test_input($_POST["remark"]) . "','R','" . $_POST["siv"] . "','" . $_COOKIE["uuid"] . "',".$_POST["requisition"].");";
                $sql .= "UPDATE `inventory` SET `location`=" . $fun->getLocationId($_POST["location"]) . ",`assigned_to`=".$fun->getEmployeeId($_POST["employee"])." WHERE `unique_id`='" . $item . "';";
            }

            $result = $conn->multi_query($sql);
        }
        if(count($_POST["items"]) == 1 ){
            foreach ($_POST["items"] as $item) {
                $item = trim(explode(" ",$item)[0]);
                $sql = "INSERT INTO `inventory transactions`(`transaction_item`,`details`, `employee`, `transaction_type`, `quantity`,`comment`,`returned`,`siv`,`created_by`,`requisition`) VALUES ('" . $fun->getItemId($_POST["item"]) . "','" . $item . "','" . $fun->getEmployeeId($_POST["employee"]) . "','" . $fun->getTransactionTypeId($_POST["transaction_type"]) . "','" . $_POST["quantity"] . "','" . $fun->test_input($_POST["remark"]) . "','R','" . $_POST["siv"] . "','" . $_COOKIE["uuid"] . "',".$_POST["requisition"].");";
                $sql .= "UPDATE `inventory` SET `location`=" . $fun->getLocationId($_POST["location"]) . ",`assigned_to`=".$fun->getEmployeeId($_POST["employee"])." WHERE `unique_id`='" . $item . "';";

                $result = $conn->multi_query($sql);
            }
        }
    }
    elseif($_POST["transaction_type"] == "Permanently Move"){
        if(count($_POST["items"]) > 1) {
            foreach ($_POST["items"] as $item) {
                $sql .= "INSERT INTO `inventory transactions`(`transaction_item`,`details`, `employee`, `transaction_type`, `quantity`,`comment`,`returned`,`siv`,`created_by`,`requisition`) VALUES (" . $fun->getItemId($_POST["item"]) . ",'" . $item . "'," . $fun->getEmployeeId($_POST["employee"]) . "," . $fun->getTransactionTypeId($_POST["transaction_type"]) . ",1,'" . $fun->test_input($_POST["remark"]) . "','Q','" . $_POST["siv"] . "','" . $_COOKIE["uuid"] . "',".$_POST["requisition"].");";
                $sql .= "UPDATE `inventory` SET `location`=" . $fun->getLocationId($_POST["location"]) . ",`type`='Fixed Asset',`assigned_to`=".$fun->getEmployeeId($_POST["employee"])."  WHERE `unique_id`='" . $item . "';";
            }
            $result = $conn->multi_query($sql);
        }
        if(count($_POST["items"]) == 1){
            foreach ($_POST["items"] as $item) {
                $sql = "INSERT INTO `inventory transactions`(`transaction_item`,`details`, `employee`, `transaction_type`, `quantity`,`comment`,`returned`,`siv`,`created_by`,`requisition`) VALUES ('" . $fun->getItemId($_POST["item"]) . "','" . $item . "','" . $fun->getEmployeeId($_POST["employee"]) . "','" . $fun->getTransactionTypeId($_POST["transaction_type"]) . "','" . $_POST["quantity"] . "','" . $fun->test_input($_POST["remark"]) . "','Q','" . $_POST["siv"] . "','" . $_COOKIE["uuid"] . "',".$_POST["requisition"].");";
                $sql .= "UPDATE `inventory` SET `location`=" . $fun->getLocationId($_POST["location"]) . ",`type`='Fixed Asset',`assigned_to`=".$fun->getEmployeeId($_POST["employee"])."  WHERE `unique_id`='" . $item . "';";

                $result = $conn->multi_query($sql);
            }
        }
    }

    if ($result == 1) {
        header('location:../newTransaction.php?success=true');
    } else {
        header('location:../newTransaction.php?success=false');
    }
}
