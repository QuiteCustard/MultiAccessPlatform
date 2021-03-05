<?php
require_once("connect.php");
//Set id to correct UID
if(isset($_POST['id'])){
    $id = mysqli_real_escape_string($db_connect,$_POST['id']);
}
if(isset($id)) {
    // Check record exists
    $checkRecord = mysqli_query($db_connect,"SELECT * FROM `t_courses` WHERE `t_courses`.`CID`=".$id);
    $totalrows = mysqli_num_rows($checkRecord);
    $title = $_POST['title'];
    $date = $_POST['date'];
    $duration = $_POST['duration'];
    $description = $_POST['description'];
    $attendees = $_POST['attendees'];
    if($totalrows > 0){
        // edit record
        $sqlQuery="UPDATE `t_courses` SET `Title` = '$title', `Date` = '$date', `Duration` = '$duration', `Max_Attendees` = '$attendees' WHERE `CID` = $id;";
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

