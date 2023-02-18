<?php
include 'include/operations/DB_Functions.php';
include 'include/operations/DB_Connect.php';

$fun = new DB_Functions();
$db = new DB_Connect();

$conn = $db->connect();

if(($handle = fopen("assets/data.csv","r")) != false){
    while (($date = fgetcsv($handle,1000,",")) != false){
        if($fun->getUnitType($date[9]) == "pcs") {
            for ($i = 1; $i <= $date[10]; $i++) {
                $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`,`location`,`manufacturer`,`model`, `reorder_level`, `target_stock_level`,`unit_price`,`unit_measure`,`quantity`,`unique_id`,`type`,`created_by`) VALUES ('" . ucwords(trim($date[0])) . "','" . $date[1] . "','" . $fun->getCategoryId($date[2]) . "','" . $fun->getLocationId($date[3]) . "'," . $date[4] . "," . $date[5] . "," . $date[6] . "," . $date[7] . "," . $date[8] . ",'" . $fun->getUnitID($date[9]) . "',1,'" . $fun->createUniqueID($date[0], $date[2], $date[11]) . "','" . $date[11] . "','" . $_COOKIE["uuid"] . "')";
                $result1 = mysqli_query($conn, $sql1);
            }
        }
        else {
            $sql1 = "INSERT INTO `inventory`(`item`, `description`, `category`,`location`,`manufacturer`,`model`, `reorder_level`, `target_stock_level`,`unit_price`,`unit_measure`,`quantity`,`unique_id`,`type`,`created_by`) VALUES ('" . ucwords(trim($date[0])) . "','" . $date[1] . "','" . $fun->getCategoryId($date[2]) . "','" . $fun->getLocationId($date[3]) . "'," . $date[4] . "," . $date[5] . "," . $date[6] . "," . $date[7] . "," . $date[8] . ",'" . $fun->getUnitID($date[9]) . "',".$date[10].",'" . $fun->createUniqueID($date[0], $date[2], $date[11]) . "','" . $date[11] . "','" . $_COOKIE["uuid"] . "')";
            $result1 = mysqli_query($conn, $sql1);
        }
    }
    echo "done";
    fclose($handle);
}

