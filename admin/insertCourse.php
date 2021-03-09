<?php
require_once("connect.php");
if(isset($_POST['title'])){
    $title = mysqli_real_escape_string($db_connect,$_POST['title']);
}
if(isset($title)) {
    // Check record exists
    $id = rand();
    $duration = $_POST['duration'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $attendees = $_POST['attendees'];

        // Insert new record
    $sqlQuery="INSERT INTO `t_courses` (`CID`, `Title`, `Date`, `Duration`, `Description`, `Timestamp`, `Max_attendees`) VALUES ('$id', '$title', '$date', '$duration', '$description', current_timestamp(), '$attendees');";
    mysqli_query($db_connect,$sqlQuery);
    echo "Record updated successfully";

} else {
    echo "Failed to update record: No ID!";
}
exit;
