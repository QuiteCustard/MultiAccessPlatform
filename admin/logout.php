<?php
//Destroy session so  you can't back into site after logging out
session_start();
session_unset();
session_destroy();
header("location:../index.php?e=4");
?>
