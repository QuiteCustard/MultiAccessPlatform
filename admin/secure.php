<?php
session_start();
// Allow login if auth is correct
if(isset($_SESSION["auth"])){
if( $_SESSION["auth"] == "admin" || $_SESSION == "user")
{
    echo "Secure login";
}
}
else
{
 die("Invalid login");   
}
?>
<a href="logout.php"></a>