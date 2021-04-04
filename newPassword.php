<?php
//Connect to db
include_once("admin/connect.php");
// Make sure token is recieved
if(isset($_GET["token"]))
{
    // If form has been completed
    if(isset($_POST["newPassword"]))
    {
        $myToken = $_GET["token"];
        $password = hash("SHA256",$_POST["newPassword"]);
        $sqlQuery = "UPDATE `t_users` set `Password` = '$password', `Serial` = NULL WHERE `t_users`.`Serial` = '$myToken';";
        $runQuery = mysqli_query($db_connect,$sqlQuery);
        die("Password has been updated");
    }

    // If form hasn't been completed
    $token = $_GET["token"];
    $query = "SELECT * FROM `t_users` WHERE `Serial` = '$token';";
    $run = mysqli_query($db_connect,$query);
    $count = mysqli_num_rows($run);

    if ($count === 1)
    {
        // Only include styles if user has token
        include_once("/include/head.php");
?>
<form method="POST" action="#">
    <input name="newPassword" type="password" required placeholder="new password">
    <button class="btn btn-primary" type="submit">Update Password</button>
</form>
<?php
    }
}
else
{
    //If token does not exist, send user back to log in
    header("location:index.php");
    die("Token did not exist");
}
