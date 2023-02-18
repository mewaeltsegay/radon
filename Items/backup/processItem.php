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
    $sql23 = "SELECT quantity as qnty,(select quantity from quantity where id=qnty) as quantity FROM `inventory` WHERE `manufacturer`='" . $_POST["manufacturer"] . "' and `model`='" . $_POST["model"] . "' and `serial_no`='" . $_POST["serialno"] . "'";
    $result23 = mysqli_query($conn,$sql23);

    if(mysqli_num_rows($result23) > 0) {
        while ($row = mysqli_fetch_assoc($result23)){
            $total = ($_POST["quantity"] + $row['quantity']);
            $id = $row["qnty"];
            $sql = "UPDATE `quantity` SET `quantity`=".$total." WHERE `id`=".$id;
            $result = mysqli_query($conn,$sql);

            if ($result == 1) {
                if(isset($_POST["submitted"]) && isset($_POST["received"]) && isset($_POST["authorised"])){
                    $sql4 = "INSERT INTO `grn`(`item_id`, `submittedby`, `receivedby`, `authorisedby`, `quantity`,`created_by`) VALUES (".$fun->getItemId($_POST["itemname"]).",".$fun->getEmployeeId($_POST["submitted"]).",".$fun->getEmployeeId($_POST["received"]).",".$fun->getEmployeeId($_POST["authorised"]).",".$_POST["quantity"].",'".$_COOKIE["uuid"]."')";
                    $result4 = mysqli_query($conn,$sql4);
                }
                header('location:../additems.php?success=true');
            } else {
                header('location:../additems.php?success=false&reason=noinsert');
            }
    }

    }
    else {
        $image = "";
        if ($_FILES['image']['name'] != "" && isset($_FILES['image'])) {
            $image = $_POST["itemname"];
            copy($_FILES['image']['tmp_name'], "images/" . $image . ".jpg") or
            header('location:../additems.php?success=false&reason=nocopy');
        }

        $disc = "";
        if (isset($_POST["discontinued"])) {
            $disc = 'Y';
        } else {
            $disc = 'N';
        }
        $quantity = 0;
        $sql = "INSERT INTO `quantity`(`item`, `quantity`, `date`) VALUES ('" . $_POST["itemname"] . "','" . $_POST["quantity"] . "','" . date("Y-m-d") . "')";
        $result = mysqli_query($conn, $sql);
        $sql2 = "select last_insert_id()";
        $result2 = mysqli_query($conn, $sql2);

        $quantity = mysqli_fetch_assoc($result2)["last_insert_id()"];

        $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`, `location`, `supplier`, `manufacturer`, `model`, `serial_no`, `reorder_level`, `target_stock_level`, `picture`, `discontinued`,`unit_price`,`unit_measure`,`expiry_date`,`quantity`,`created_by`) VALUES ('" . ucwords($_POST["itemname"]) . "','" . $_POST["description"] . "','" . $fun->getCategoryId($_POST["category"]) . "','" . $fun->getLocationId($_POST["location"]) . "','" . $_POST["supplier"] . "','" . $_POST["manufacturer"] . "','" . $_POST["model"] . "','" . $_POST["serialno"] . "'," . $_POST["reorderlevel"] . "," . $_POST["target"] . ",'" . $image . "','" . $disc . "'," . $_POST["price"] . ",'" . $_POST["measure"] . "','" . $_POST["expire"] . "'," . $quantity . ",'".$_COOKIE["uuid"]."')";
        $result1 = mysqli_query($conn, $sql1);


        if ($result1 == 1) {
            if(isset($_POST["submitted"]) && isset($_POST["received"]) && isset($_POST["authorised"])){
                $sql4 = "INSERT INTO `grn`(`item_id`, `submittedby`, `receivedby`, `authorisedby`, `quantity`,`created_by`) VALUES (".$fun->getItemId($_POST["itemname"]).",".$fun->getEmployeeId($_POST["submitted"]).",".$fun->getEmployeeId($_POST["received"]).",".$fun->getEmployeeId($_POST["authorised"]).",".$_POST["quantity"].",'".$_COOKIE["uuid"]."')";
                $result4 = mysqli_query($conn,$sql4);
            }
            if($image != "") {
                $fun->createThumb("images/", $_POST["itemname"] . ".jpg");
            }
            header('location:../additems.php?success=true');
        } else {
            header('location:../additems.php?success=false&reason=noinsert');
        }
    }

}
