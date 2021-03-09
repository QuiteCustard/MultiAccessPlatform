<?php
require_once("connect.php");
if(isset($_POST['email'])){
    $email = mysqli_real_escape_string($db_connect,$_POST['email']);
}
if(isset($email)) {
    // Check record exists
    $id = rand();
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $job = $_POST['job'];
    $access = $_POST['access'];
    $course = $_POST['course'];

        // edit record
$sqlQuery="INSERT INTO `t_users` (`UID`, `Fname`, `Lname`, `Jobtitle`, `Email`, `Password`, `Access`, `Currentcourse`, `Attempts`, `Timestamp`, `Serial`) VALUES ('$id', '$fname', '$lname', '$job', '$email', '$password', '$access', '$course', '0', current_timestamp(), NULL);";
        mysqli_query($db_connect,$sqlQuery);
        echo "Record updated successfully";

} else {
    echo "Failed to update record: No ID!";
}
exit;
