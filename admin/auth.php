<?php

if( !isset($_POST["Email"]) or !isset($_POST["Password"]))
{
//if no values are passed from login form, do this
header("Location: ../index.php?e=1");
}
//if values are found, proceed:
$email = strval($_POST["Email"]);
//convert our plain password to a hash
$password = strval(hash("sha256",$_POST["Password"]));
//run our query
$query = "SELECT * FROM `t_users` WHERE `Email` = '$email' AND `Password` = '$password'";

include_once("connect.php");
$run = mysqli_query($db_connect,$query);
//count matches.  Will return 1 if match found.
$result =  mysqli_fetch_assoc($run);

$count = mysqli_num_rows($run);

echo $count;


//will return 1 if a username/password match is found
if ($count === 1){
    // Check access level
    $access = $result["Access"];
    echo $access;
  //let us log in
    session_start();
    $_SESSION["auth"] = $access;
    //Remember name
    $_SESSION["name"] = $result["Fname"] . " " . $result["Lname"];
  header("Location: index.php");
    die();
}
else 
{
//if 1 is not returned, redirect to login page with e=2
   header("Location: ../index.php?e=2");
    die("Wrong information");
}
?>
