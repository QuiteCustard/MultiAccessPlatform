<?php
require_once ("connect.php");
include_once("_logincheck.php");
if (isset($_GET['case']))
{
    $case = $_GET['case'];
    switch ($case)
    {
            // Get user data

        case "getUserData":
            if ($auth == "admin"){
                    $query = "SELECT * FROM `t_users`";
            }
            else{
                $query = "SELECT * FROM `t_users` WHERE `UID` =" . $_SESSION['userid'] . ";";
            }
            $result = mysqli_query($db_connect, $query);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='idResult'>".$row['UID']."</td>";
                    echo "<td class='emailResult'>".$row['Email']."</td>";
                    echo "<td class='fNameResult'>".$row['Fname']."</td>";
                    echo "<td class='lNameResult'>".$row['Lname']."</td>";
                    echo "<td class='jobResult'>".$row['Jobtitle']."</td>";
                    echo "<td class='accessResult'>".$row['Access']."</td>";
                    if ($row['Currentcourse'] == ""){
                        echo "<td class='courseResult'>None</td>";
                    }
                    else{
                        echo "<td class='courseResult'>".$row['Currentcourse']."</td>";
                    }
                    echo "<td>".$row['Timestamp']."</td>";
                    echo "<td><button data-id='".$row['UID']."'class='btn bg-warning text-white edit'>Edit</button></td>";
                    // Prevent user from deleting their own account
                    if ($auth == "admin"){
                        echo "<td><button data-id='".$row['UID']."'class='btn bg-danger text-white delete'>Delete</button></td>";
                    }
                    echo"</tr>";
                }

            }
            else {
                echo "0 results";
            }
            break;
        // Get course data
        case "getCourseData":
            $query = "SELECT * FROM `t_courses`";
            $result = mysqli_query($db_connect, $query);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='idResult'>".$row['CID']."</td>";
                    echo "<td class='titleResult'>".$row['Title']."</td>";
                    echo "<td class='dateResult'>".$row['Date']."</td>";
                    echo "<td class='durationResult'>".$row['Duration']."</td>";
                    echo "<td class='descriptionResult'>".$row['Description']."</td>";
                    echo "<td class='attendeesResult'>".$row['Max_attendees']."</td>";
                    echo "<td>".$row['Timestamp']."</td>";
                    if ($auth == "admin"){
                        echo "<td><button data-id='".$row['CID']."'class='btn bg-warning text-white edit'>Edit</button></td>";
                        echo "<td><button data-id='".$row['CID']."'class='btn bg-danger text-white delete'>Delete</button></td>";
                    }
                    echo "</tr>";
                }
            }
            else {
                echo "0 results";
            }
            break;
        case "getEnrolCourse":
            // Select all courses from database
            $query = "SELECT * FROM `t_courses`";
            $result = mysqli_query($db_connect, $query);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='idResult'>".$row['CID']."</td>";
                    echo "<td class='titleResult'>".$row['Title']."</td>";
                    echo "<td><button data-id='".$row['CID']."'class='btn bg-success text-white enrol'>Enrol</button></td>";
                    echo"</tr>";
                }
            }
            else {
                echo "0 results";
            }
            break;
        case "getUserOnCourse":
            // Select all courses from database
            $query = "SELECT * FROM `t_courses`";
            $result = mysqli_query($db_connect, $query);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td class='idResult'>".$row['CID']."</td>";
                    echo "<td class='titleResult'>".$row['Title']."</td>";
                    echo "<td><button data-id='".$row['CID']."'class='btn bg-success text-white enrol'>Enrol</button></td>";
                    echo"</tr>";
                }
            }
            else {
                echo "0 results";
            }
            break;
        }
    }
    else if (isset($_POST['case']))
    {
        $case = $_POST['case'];
        switch ($case)
        {
                // delete user data

            case "deleteUser":
                $id = 0;
                if (isset($_POST['id']))
                {
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                }
                // Preventation of deleting owner account
                if ($id==1)
                {
                    die("You cannot delete this account");
                }
               elseif ($id > 0)
                {
                    // Check record exists
                    $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_users` WHERE `t_users`.`UID`=" . $id);
                    $totalrows = mysqli_num_rows($checkRecord);
                    if ($totalrows > 0)
                    {
                        // Delete record
                        $query = "DELETE FROM `t_users` WHERE `t_users`.`UID`=" . $id;
                        mysqli_query($db_connect, $query);
                        echo "Record successfully deleted";
                        exit;
                    }
                    else
                    {
                        echo "Record unsuccessfully deleted";
                        exit;
                    }
                }
                echo 0;
                exit;
            break;
                // Get course data

            case "deleteCourse":
                //Set id to correct UID
                $id = 0;
                if (isset($_POST['id']))
                {
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                }
                if ($id > 0)
                {
                    // Check record exists
                    $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_courses` WHERE `t_courses`.`CID`=" . $id);
                    $totalrows = mysqli_num_rows($checkRecord);

                    if ($totalrows > 0)
                    {
                        // Delete record
                        $query = "DELETE FROM `t_courses` WHERE `t_courses`.`CID`=" . $id;
                        mysqli_query($db_connect, $query);
                        echo "Record successfully deleted";
                        exit;
                    }
                    else
                    {
                        echo "Record unsuccessfully deleted";
                        exit;
                    }
                }

                echo 0;
                exit;

            break;
                // save user data
            case "courseSelector":
                function courseValF($db_connect){
                    $query = "SELECT `CID`,`Title` FROM `t_courses`;";
                    $run = mysqli_query($db_connect, $query);
                    if (mysqli_num_rows($run) > 0) {
                        // Get Course current value
                        $course = $_POST["courseVal"];
                        $course_options ="";
                        // output data of each row
                        while($row = mysqli_fetch_assoc($run)) {
                            //Display course titles as options
                            $title = $row["Title"];
                            $cid = $row["CID"];
                            $course_options .= "<option data-cid='$cid' value='$title'";
                            if ($title == $course) {
                              $course_options .= "selected='selected'";
                            }
                            $course_options .= ">$title</option>";
                        }
                        $selectCourse = '<select class="form-control primary selectors" id="courseSelect" name="course_option"><option value="None">None</option>'.$course_options.'</select>';
                        echo $selectCourse;
                    }
                }
                courseValF($db_connect);
                break;
            case "accessSelector":
                function accessValF($db_connect){
                    $query = "SELECT DISTINCT `Access` FROM `t_users`;";
                    $run = mysqli_query($db_connect, $query);
                    if (mysqli_num_rows($run) > 0) {
                    // Get Course current value
                    $access = $_POST["accessVal"];
                    $course_options ="";
                    while ($result = mysqli_fetch_assoc($run))
                    {
                        //Display course titles as options
                        $title = $result["Access"];
                        $course_options .= "<option value='$title'";
                        if ($title == $access) {
                          $course_options .= "selected='selected'";
                        }
                        $course_options .= ">$title</option>";
                    }
                    $selectCourse = '<select class="form-control form-control-user primary selectors" id="course" name="course_option">' .$course_options.'</select>';
                    echo $selectCourse;
                    }
                }
                accessValF($db_connect);
                break;
            case "saveUser":
                //Set id to correct UID
                if (isset($_POST['id']))
                {
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                }
                // Preventation of editing owner account
                if ($id == 1)
                {
                    die("You cannot edit this account");
                }
                elseif ($id > 0)
                {
                    if (isset($id))
                    {
                        // Check record exists
                        $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_users` WHERE `t_users`.`UID`='$id';");
                        $totalrows = mysqli_num_rows($checkRecord);
                        $email = $_POST['email'];
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $job = $_POST['job'];
                        $access = $_POST['access'];
                        $course = $_POST['course'];
                        $cid = $_POST['cid'];
                        if ($totalrows > 0)
                        {
                            // edit record
                            $sqlQuery = "UPDATE `t_users` SET `Fname` = '$fname', `Lname` = '$lname', `Jobtitle` = '$job', `Email` = '$email', `Access` = '$access', `Currentcourse` = '$course' WHERE `t_users`.`UID` = '$id';";
                            mysqli_query($db_connect, $sqlQuery);
                            // Function to insert a new record to enrolment table
                            function updateEnrolmentTable($db_connect, $id, $cid){
                                if (isset($cid)){
                                    $sql = "REPLACE INTO `t_enrolment`(`EID`, `UID`, `CID`) VALUES (`EID`, '$id', '$cid');";
                                    mysqli_query($db_connect, $sql);
                                }
                           else if($course == "" || $course == "None"){
                               $sql = "DELETE FROM `t_enrolment` WHERE `t_enrolment`.`UID` = '$id';";
                                    mysqli_query($db_connect, $sql);
                           }
                                else{
                                    die("Can't update" . $sql);
                                }
                            }
                            updateEnrolmentTable($db_connect, $id, $cid);
                            echo "Record updated successfully";
                        }
                        else
                        {
                            echo "Update failed, no records found.";
                        }
                    }
                    else
                    {
                        echo "Failed to update record: No ID!";
                    }
               }
                exit;
            break;
                // save course data

            case "saveCourse":
                //Set id to correct UID
                if (isset($_POST['id']))
                {
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                }
                if (isset($id))
                {
                    // Check record exists
                    $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_courses` WHERE `t_courses`.`CID`= $id;");
                    $totalrows = mysqli_num_rows($checkRecord);
                    $title = $_POST['title'];
                    $date = $_POST['date'];
                    $duration = $_POST['duration'];
                    $description = $_POST['description'];
                    $attendees = $_POST['attendees'];
                    if ($totalrows > 0)
                    {
                        // edit record
                        $sqlQuery = "UPDATE `t_courses` SET `Title` = '$title', `Date` = '$date', `Duration` = '$duration', `Description` = '$description', `Max_Attendees` = '$attendees' WHERE `CID` = $id;";
                        mysqli_query($db_connect, $sqlQuery);
                        echo "Record updated successfully";
                    }
                    else
                    {
                        echo "Update failed, no records found.";
                    }
                }
                else
                {
                    echo "Failed to update record: No ID!";
                }
                exit;
            break;
            case "insertUser":
                if (isset($_POST['email']))
                {
                    $email = mysqli_real_escape_string($db_connect, $_POST['email']);
                }
                if (isset($email))
                {
                    // Check record exists
                    $id = rand(10, 99999);
                    $password = $_POST['password'];
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $job = $_POST['job'];
                    $access = $_POST['access'];
                    $course = $_POST['course'];
                    $cid = $_POST['newUserCid'];
                    // Insert new record
                    $sqlQuery = "INSERT INTO `t_users` (`UID`, `Fname`, `Lname`, `Jobtitle`, `Email`, `Password`, `Access`, `Currentcourse`, `Attempts`, `Timestamp`, `Serial`) VALUES ('$id', '$fname', '$lname', '$job', '$email', '$password', '$access', '$course', '0', current_timestamp(), NULL);";
                    mysqli_query($db_connect, $sqlQuery);
                    echo "Record updated successfully";
                    // Function to insert a new record to enrolment table
                    function insertEnrolmentTable($db_connect, $id, $cid){
                        $sql = "INSERT INTO t_enrolment (UID, CID) VALUES ($id, $cid);";
                        mysqli_query($db_connect, $sql);
                    }
                    insertEnrolmentTable($db_connect, $id, $cid);

                }
                else
                {
                    echo "Failed to update record: No ID!";
                }
                exit;
            break;
            case "insertCourse":
                if (isset($_POST['title']))
                {
                    $title = mysqli_real_escape_string($db_connect, $_POST['title']);
                }
                if (isset($title))
                {
                    // Check record exists
                    $id = rand(10, 99999);
                    $duration = $_POST['duration'];
                    $description = $_POST['description'];
                    $date = $_POST['date'];
                    $attendees = $_POST['attendees'];
                    echo $date;
                    // Insert new record
                    $sqlQuery = "INSERT INTO `t_courses` (`CID`, `Title`, `Date`, `Duration`, `Description`, `Timestamp`, `Max_attendees`) VALUES ('$id', '$title', '$date', '$duration', '$description', current_timestamp(), '$attendees');";
                    mysqli_query($db_connect, $sqlQuery);
                    echo "Record updated successfully";

                }
                else
                {
                    echo "Failed to update record: No ID!";
                }
                exit;

                break;
            case "insertUserToCourse":
                if (isset($_POST['newUserCid']))
                {
                    $id = $_POST['newUserCid'];
                }
                if (isset($id))
                {
                    // Function to insert a new record to enrolment table
                    function enrolmentTable($db_connect, $id){
                    $sql = "INSERT INTO t_enrolment (UID, CID) VALUES (" . $_SESSION['userid']  .", $id);";
                    mysqli_query($db_connect, $sql);
                    }
                    enrolmentTable($db_connect, $id);
                    // Function to change current course to one just clicked
                    function userCourse($db_connect, $id){
                    $sql = "UPDATE `t_users` SET `Currentcourse` = (SELECT `Title` FROM `t_courses` WHERE `CID` = $id) WHERE `UID` = " . $_SESSION['userid'] . ";";
                    mysqli_query($db_connect, $sql);
                    }
                    userCourse($db_connect, $id);
                    echo "Records updated successfully";
                }
                else
                {
                    echo "Failed to update record!";
                }
                exit;
                break;
            case "userCourseOptions":
                break;
        }

    }
    else
    {
        echo "No case set";
        die();
    }
