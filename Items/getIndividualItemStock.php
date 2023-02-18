<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/14/2020
 * Time: 7:46 PM
 */

include "../include/operations/DB_Functions.php";

$fun = new DB_Functions();

if(isset($_GET["type"])){
    echo json_encode($fun->getItemDetails($_GET["name"],'relocate'));
}
else{
    echo json_encode($fun->getItemDetails($_GET["name"]));
}

