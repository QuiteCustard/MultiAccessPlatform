<?php
//Connect to db
require_once("admin/connect.php");
include_once("/include/head.php");
// Make sure token is recieved
if(isset($_GET["token"]))
{
    // If form has been completed
    if(isset($_POST["newPassword"]))
    {
        $myToken = $_GET["token"];
        $password = hash("SHA256",$_POST["newPassword"]);
        $sqlQuery = "UPDATE `t_users` set `Password` = '$password', `Serial` = NULL WHERE `t_users`.`Serial` = '$myToken';";
        $runQuery = mysqli_query($mysqli,$sqlQuery);
        die("Password has been updated");
    }

    // If form hasn't been completed
    $token = $_GET["token"];
    $query = "SELECT * FROM `t_users` WHERE `Serial` = '$token';";
    $run = mysqli_query($mysqli,$query);
    $count = mysqli_num_rows($run);

    if ($count === 1)
    {
        // Only include if user has token
?>
<body class="tertiary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6 primary text">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-4 textOuter">Reset your password here!</h1>
                                    </div>
                                    <form method="POST" action="#">
                                        <div class="form-group">
                                            <input name="newPassword" type="password" required placeholder="new password">
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block secondary secondaryBorder" required placeholder="new password" action="submit" type="submit">Update Password</button>
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
