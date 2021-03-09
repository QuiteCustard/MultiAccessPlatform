<?php
// connect
include_once("connect.php");
// Generated random token
$token = md5(uniqid());

$email = $_POST["email"];
    //Check if email has been entered
if(isset($email)){
    /*
    $email = mysqli_real_escape_string($db_connect,$_POST['email']);
}
if(isset($email)) {
    // Check record exists
    $checkRecord = mysqli_query($db_connect,"SELECT * FROM `t_users` WHERE `t_users`.`Email`=".$email);
    $totalrows = mysqli_num_rows($checkRecord);
    if($totalrows > 0){*/
        // edit record

    echo $email;
       $query = "UPDATE `t_users` SET `Serial` = '$token' WHERE `t_users`.`Email` = '$email';";
        mysqli_query($db_connect,$query);
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
                    <p>Reset your password by clicking the following link: <a href='https://ws269058wad.remote.ac/newPassword.php?token=$token'>https://ws269058wad.remote.ac/newPassword.php?token=$token</a></p>
                    <p>Thanks</p>
                    <p><i>ATW Team</i></p>
                    </body>
                    </html>";

        mail($to, $subject,$message,$headers);
        echo "Password reset email sent to $to";
  }
    else {
        echo "Update failed, no records found.";

    }
 //else {
   // echo "Failed to update record: No email!";
//}
exit;
