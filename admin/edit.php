<?php
require_once("connect.php");
//Set id to correct UID
$id = 0;
if(isset($_POST['id'])){
   $id = mysqli_real_escape_string($db_connect,$_POST['id']);
}
if($id > 0){
  // Check record exists
  $checkRecord = mysqli_query($db_connect,"SELECT * FROM `t_users` WHERE `t_users`.`UID`=".$id);
  $totalrows = mysqli_num_rows($checkRecord);

    $query = "SELECT * FROM `t_users`";
    $run = mysqli_query($db_connect,$query);
    $result =  mysqli_fetch_assoc($run);
    $fname = $result["Email"];
    $lname = $result["Fname"];
    $email = $result["Lname"];

    if($totalrows > 0){
    // Delete record
    $sqlQuery="UPDATE `t_users` SET `UID` = 'UID', `email` = '$email',"/*`PW` = '$password', */. "`Fname` = '$fname', `Lname` = '$lname' WHERE `UID` = $id";
    mysqli_query($db_connect,$sqlQuery);
    echo 1;
    exit;
    }else{
    echo 0;
    exit;
    }
}

echo 0;
exit;
