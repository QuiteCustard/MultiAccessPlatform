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

  if($totalrows > 0){
    // Delete record
    $query = "DELETE FROM `t_users` WHERE `t_users`.`UID`=".$id;
    mysqli_query($db_connect,$query);
    echo "Record successfully deleted";
    exit;
  }else{
    echo "Record unsuccessfully deleted";
    exit;
  }
}

echo 0;
exit;