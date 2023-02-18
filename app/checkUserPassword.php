<?php
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $password = $_POST["old"];
    $id = $_POST["uuid"];

    $sql = "select password,salt from users where uuid = '{$id}'";
    $result = mysqli_query($conn,$sql);

    if(mysqli_num_rows($result) == 1){
        while($row = mysqli_fetch_assoc($result)){
            $hashed_pass = $row["password"];
            $hash = $fun->checkhashSSHA($row["salt"],$password);

            if($hashed_pass == $hash){
                echo "true";
            }
            else{
                echo "false";
            }
        }
    }
}
