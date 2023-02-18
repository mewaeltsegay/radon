<?php
/**
 * Created by PhpStorm.
 * User: NCEW
 * Date: 7/21/2020
 * Time: 8:59 PM
 */

setcookie("username", "", time() - 3600,'/');
setcookie("deptid", "", time() - 3600,'/');
setcookie("usertype", "", time() - 3600,'/');
setcookie("uname", "", time() - 3600,'/');
setcookie("uuid", "", time() - 3600,'/');

header('Location:login.php');