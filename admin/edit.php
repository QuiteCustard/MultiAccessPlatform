<?php
require_once("connect.php");
//Set id to correct UID
if(isset($_POST['id'])){
    $id = mysqli_real_escape_string($db_connect,$_POST['id']);
}
if(isset($id)) {
    // Check record exists
    $checkRecord = mysqli_query($db_connect,"SELECT * FROM `t_users` WHERE `t_users`.`UID`=".$id);
    $totalrows = mysqli_num_rows($checkRecord);
    $email = $_POST['email'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    if($totalrows > 0){
        // edit record
        $sqlQuery="UPDATE `t_users` SET `email` = '$email', `Fname` = '$fname', `Lname` = '$lname' WHERE `UID` = $id;";
        mysqli_query($db_connect,$sqlQuery);
        echo "Record updated successfully";
    }
    else {
        echo "Update failed, no records found.";
    }
} else {
    echo "Failed to update record: No ID!";
}
exit;