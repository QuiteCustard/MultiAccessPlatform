<?php
include_once("connect.php");
// Select all users from database
$query = "SELECT 'Coursetitle' FROM `t_course`";
$result =  mysqli_fetch_assoc($db_connect,$query);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        echo json_encode($row["Coursetitle"]);
    }
} else {

}
