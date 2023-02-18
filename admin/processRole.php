<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 8/10/2020
 * Time: 10:23 PM
 */
include '../include/operations/DB_Functions.php';
include '../include/operations/DB_Connect.php';
include '../include/operations/login.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

$login = new login();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $sql = "INSERT INTO `roles`(`name`, `description`) VALUES ('".ucwords($_POST["role"])."','".$_POST["description"]."')";
    $result = mysqli_query($conn,$sql);

    if($result == 1){
        foreach ($_POST as $key => $value){
            if($key!= 'role' and $key!='description'){
                $sql2 = "INSERT INTO `permission_role`(`role_id`, `permission_id`) VALUES (".$fun->getRoleID($_POST["role"]).",".$key.")";
                $result2 = mysqli_query($conn,$sql2);
            }
        }
        header('location:../roles.php#newrole?success=true');
    }
    else{
        header('location:../roles.php#newrole?success=false');
    }
}