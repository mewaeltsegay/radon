<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 6/7/2020
 * Time: 3:39 PM
 */
include '../include/operations/DB_Connect.php';
include '../include/operations/DB_Functions.php';

$db = new DB_Connect();
$conn = $db->connect();

$fun = new DB_Functions();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $image = "";
    if ($_FILES['image']['name'] != "" && isset($_FILES['image'])) {
        $image = $fun->createAssetID($_POST["itemname"],$_POST["category"],$_POST["location"]);
        copy($_FILES['image']['tmp_name'], "images/" . $image . ".jpg") ;
    }
    $qty = $_POST["quantity"];
    $sql = "";
    $result = "";

    if($fun->getUnitType($_POST["measure"]) == "pcs"){
        for($i = 1;$i <= $qty; $i++){
            $sql = "insert into `fixed_asset` (item,unique_id,description,category,location,manufacturer,model,serial_no,unit_price,unit_measure,quantity,picture)
            values('".$_POST["itemname"]."','".$fun->createAssetID($_POST["itemname"],$_POST["category"],$_POST["location"])."','".$_POST["description"]."',".$fun->getCategoryId($_POST["category"]).",".$fun->getLocationId($_POST["location"]).",
                    '".$_POST["manufacturer"]."','".$_POST["model"]."','".$_POST["serialno"]."','".$_POST["price"]."','".$_POST["measure"]."',1,
                    '".$image."')";
            $result = mysqli_query($conn,$sql);
        }
        if($result == 1){
            if($image != "") {
                $fun->createThumb("images/", $image . ".jpg");
            }
            header('location:../newFixedAsset.php?success=true');
        } else {
            header('location:../newFixedAsset.php?success=false&reason=noinsert');
        }
    }
    else{
        $sql = "insert into `fixed_asset` (item,unique_id,description,category,location,manufacturer,model,serial_no,unit_price,unit_measure,quantity,picture)
            values('".$_POST["itemname"]."','".$fun->createAssetID($_POST["itemname"],$_POST["category"],$_POST["location"])."','".$_POST["description"]."',".$fun->getCategoryId($_POST["category"]).",".$fun->getLocationId($_POST["location"]).",
                    '".$_POST["manufacturer"]."','".$_POST["model"]."','".$_POST["serialno"]."','".$_POST["price"]."','".$_POST["measure"]."',".$_POST["quantity"].",
                    '".$image."')";
        $result = mysqli_query($conn,$sql);

        if($result == 1){
            if($image != "") {
                $fun->createThumb("images/", $image . ".jpg");
            }
            header('location:../newFixedAsset.php?success=true');
        } else {
            header('location:../newFixedAsset.php?success=false&reason=noinsert');
        }
    }

}