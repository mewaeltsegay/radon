<?php
include "../include/operations/DB_Functions.php";

$fun = new DB_Functions();

$image = $fun->randomPicIDApp();
move_uploaded_file($_FILES['picture']['tmp_name'], "../items/images/" . $image . ".jpg");
echo $image;
