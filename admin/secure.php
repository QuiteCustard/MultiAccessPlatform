<?php
session_start();

if(isset($_SESSION["auth"])){
if( $_SESSION["auth"] == "admin")
{
    echo "Secure login";
}
}
else
{
 die("Invalid login");   
}
?>
<a href="LogOut.php"></a>