<?php
session_start();
// Allow login if auth is correct
if(isset($_SESSION["auth"])){
    if( $_SESSION["auth"] == "admin" || $_SESSION["auth"] == "user" || $_SESSION["auth"] == "owner"){
    echo "Secure login";
    }
}else{
 die("Invalid login");   
}

echo "<a href='logout.php'></a">;