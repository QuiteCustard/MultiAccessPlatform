<?php 
// Not currently in use
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


    $fname = $_POST["FNAME"];
    echo $fname;
    $lname = $_POST["LNAME"];
    echo $lname;
    $email = $_POST["EMAIL"];
    echo $email;
    //$password = $_POST["PASSWORD"];
    //echo $password;

  if($totalrows > 0){
    // Delete record
   $query="UPDATE `t_users` SET `UID` = '', `EMAIL` = '$email',"/*`PW` = '$password',  */. "`FNAME` = '$fname', `LNAME` = '$lname' WHERE `UID` = $id";
    mysqli_query($db_connect,$query);
    echo 1;
    exit;
  }else{
    echo 0;
    exit;
  }
}

echo 0;
exit;
