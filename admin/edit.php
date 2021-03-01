<?php 
// Not currently in use
/*require_once("connect.php");



if( isset($_POST["EMAIL"]))
{

    $fname = $_POST["FNAME"];
    echo $fname;
    $lname = $_POST["LNAME"];
    echo $lname;
    $email = $_POST["EMAIL"];
    echo $email;
    $password = $_POST["PASSWORD"];
    echo $password;


    $query="UPDATE `t_users` SET `UID` = '', `EMAIL` = '$email', `PW` = '$password', `FNAME` = '$fname', `LNAME` = '$lname'";

    mysqli_query($db_connect,$query);

    echo $email." User Has Been edited!";
    echo $query;
    header("location:index.php");

}
else
{
    die("User not updated");
}



?>

<a href="index.php" type="text">Back To Management</a>
