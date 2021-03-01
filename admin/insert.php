<?php
// Not currently in use
/*
if(!isset($_POST["Email"]) or !isset($_POST["Password"]))
{
    die("no input");
}

else
{
    include_once("connect.php");
    $email = $_POST["Email"];
    $password = hash("sha256",$_POST["Password"]);
    $sql = "INSERT INTO `t_users` (`UID`, `Email`, `Password`, `Access`, `Attempts`, `Timestamp`) VALUES (NULL, '$email', '$password', 'pending', '0', current_timestamp());";
                     mysqli_query($db_connect,$sql);
                     Echo "User $email has been added";
}
*/
