<?php 
require_once("connect.php");

$UID=$_GET["UID"];

$query="DELETE FROM `t_users` WHERE `t_users`.`UID` = $UID";
header("location:index.php");

mysqli_query($db_connect,$query);


?>