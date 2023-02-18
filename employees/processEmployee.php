<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/12/2020
 * Time: 4:19 PM
 */

include "../include/operations/DB_Connect.php";
include "../include/operations/DB_Functions.php";
$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

if( $_FILES['picture']['name'] != "" )
{
    $image = $_POST["first_name"].$_POST["last_name"];
    copy( $_FILES['picture']['tmp_name'], "images/".$image.".jpg" ) or
    header('location:../addEmployee.php?success=false2');
}
else
{
    $image = $_POST["picture"];
}
$result = "";
if(isset($_POST["first_name"]) && isset($_POST["last_name"])) {
    $sql = "INSERT INTO `employees`(`first_name`, `last_name`, `department`, `work_phone`, `home_phone`, `mobile_phone`, `address`, `city`, `zoba`,`picture`,`created_by`) VALUES ('" . ucwords($_POST["first_name"]) . "','" . ucwords($_POST["last_name"]) . "','" . $fun->getDeptID($_POST["department"]) . "','" . $_POST["work_phone"] . "','" . $_POST["home_phone"] . "','" . $_POST["mobile_phone"] . "','" . ucwords($_POST["address"]) . "','" . ucwords($_POST["city"]) . "','" . ucwords($_POST["zoba"]) . "','" . $image . "','".$_COOKIE["uuid"]."')";
    $result = mysqli_query($conn, $sql);
}
else{
    $result = 0;
}

if($result == 1){
    header('location:../addEmployee.php?success=true');
    $fun->createThumb("images/",$image.".jpg");
}
else{
    header('location:../addEmployee.php?success=false');
}
