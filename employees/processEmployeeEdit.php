<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/12/2020
 * Time: 6:25 PM
 */

include "../include/operations/DB_Connect.php";
include "../include/operations/DB_Functions.php";

$db = new DB_Connect();
$conn = $db->connect();
$fun = new DB_Functions();
$image = "";
    if ($_FILES['picture']['name'] != "") {
        $image = $_POST["first_name"].$_POST["last_name"];
        copy($_FILES['picture']['tmp_name'], "images/" . $image . ".jpg") or
        header('location:../addEmployee.php?success=false2&id='.$_GET["id"]);
    } else {
        if(isset($_POST["saved"])){
         $image = $_POST["saved"];
        }
    }
$sql = "";

$sql = "UPDATE `employees` SET `first_name`='" . $_POST["first_name"] . "',`last_name`='" . $_POST["last_name"] . "',`department`='" . $fun->getDeptID($_POST["department"]) . "',`work_phone`='" . $_POST["work_phone"] . "',`home_phone`='" . $_POST["home_phone"] . "',`mobile_phone`='" . $_POST["mobile_phone"] . "',`address`='" . $_POST["address"] . "',`city`='" . $_POST["city"] . "',`zoba`='" . $_POST["zoba"] . "',`picture`='" . $image . "' WHERE id=" . $_GET["id"];
$result = mysqli_query($conn,$sql);

if($result == 1){
    header('location:../editEmployee.php?success=true&id='.$_GET["id"]);
    $fun->createThumb("images/",$image.".jpg");
}
else{
    header('location:../editEmployee.php?success=false&id='.$_GET["id"]);
}