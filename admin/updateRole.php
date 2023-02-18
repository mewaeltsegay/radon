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

$rolename = $_GET["rolename"];
$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

$login = new login();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    $oldPermissions = array();

    $sql = "update `roles` set `name`='".ucwords($_POST["role"])."',`description`='".$_POST["description"]."' where name='".$rolename."'";
    $result = mysqli_query($conn,$sql);

    if($result == 1) {
        $sqlPermissions = "SELECT permission_id FROM permission_role WHERE role_id=" . $fun->getRoleID($_POST["role"]);
        $res = mysqli_query($conn, $sqlPermissions);

        if (mysqli_num_rows($res) > 0) {
            while ($row = mysqli_fetch_assoc($res)) {
                array_push($oldPermissions, $row["permission_id"]);
            }
        }

        foreach ($_POST as $key => $value){
            if($key!= 'role' and $key!='description'){
                if(!in_array($key,$oldPermissions)) {
                    $sql2 = "INSERT INTO `permission_role`(`role_id`, `permission_id`) VALUES (". $fun->getRoleID($_POST["role"]) . "," . $key . ")";
                    $result2 = mysqli_query($conn, $sql2);
                }
            }
        }
        foreach ($oldPermissions as $permission){
            if(!in_array($permission,array_keys($_POST))){
                $sql3 = "delete from permission_role where role_id=".$fun->getRoleID($_POST["role"])." and permission_id=".$permission;
                $result3 = mysqli_query($conn,$sql3);
            }
        }
        header('location:../roledetails.php?success=true&role='.$_POST["role"]);
    }
//    $sql = "update `roles` set `name`= '".ucwords($_POST["role"])."', `description` = '".$_POST["description"]."'";
//    $result = mysqli_query($conn,$sql);
//
//    if($result == 1){
//        foreach ($_POST as $key => $value){
//            if($key!= 'role' and $key!='description'){
//                $sql2 = "INSERT INTO `permission_role`(`role_id`, `permission_id`) VALUES (".$fun->getRoleID($_POST["role"]).",".$key.")";
//                $result2 = mysqli_query($conn,$sql2);
//            }
//        }
//        header('location:../roledetails.php?success=true');
//    }
    else{
        header('location:../roledetails.php?success=false&role='.$_POST["role"]);
    }
}