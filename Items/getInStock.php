<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 5/13/2020
 * Time: 4:20 PM
 */

include "../include/operations/DB_Functions.php";

$fun = new DB_Functions();

$myobj["instock"] = $fun->getActualItemQuantity($_GET["item"]);
$myobj["unit"] = $fun->getItemMeasure($_GET["item"]);

echo json_encode($myobj);