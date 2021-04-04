<?php
// connect
require_once("connect.php");
// Generated random token
$token = md5(uniqid());
//Check if email has been entered
$email = $_POST["email"];
if(isset($email)){
        // edit record
    $query = "UPDATE `t_users` SET `Serial` = '$token' WHERE `t_users`.`Email` = '$email';";
    $run = mysqli_query($db_connect,$query);
    echo "Query has been run";
    //SEND THE EMAIL
    $to = "$email";
    $subject = "ATW Password Reset";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "Cc: WS269058@weston.ac.uk"."\r\n";
    $headers .= "From: no-reply@remote.ac"."\r\n";
    $message = "
                <html>
                    <head>
                        <title>Password Reset</title>
                    </head>
                    <body>
                        <h1>Reset your password </h1>
                        <p>Reset your password by clicking the following link: <a href='https://ws269058wad.remote.ac/newPassword.php?token=$token'>Reset Here</a></p>
                        <p>Thanks</p>
                        <p><i>ATW Team</i></p>
                    </body>
                </html>";
    mail($to, $subject,$message,$headers);
    echo "Password reset email sent to $to";
}else {
    echo "Update failed, no records found.";
}
exit;
