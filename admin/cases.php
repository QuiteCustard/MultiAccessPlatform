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
            if ($auth == "owner" || $auth == "admin"){
                $query = "SELECT * FROM `t_users`;";
            }
            else{
                $query = "SELECT * FROM `t_users` WHERE `UID` =" . $_SESSION['userid'] . ";";
            }
            $result = mysqli_query($db_connect, $query);
            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)){
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
                    if ($auth == "admin" || $auth == "owner"){
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
            function getCourseData($db_connect, $auth){
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
                        if ($auth == "admin" || $auth == "owner"){
                            echo "<td><button data-id='".$row['CID']."'class='btn bg-warning text-white edit'>Edit</button></td>";
                            echo "<td><button data-id='".$row['CID']."'class='btn bg-danger text-white delete'>Delete</button></td>";
                        }
                        echo "</tr>";
                    }
                }
                else {
                    echo "0 results";
                }
            }
            getCourseData($db_connect, $auth);
            break;
        case "getEnrolCourse":
            // Select all courses from database
            $query = "SELECT * FROM `t_courses`;";
            $result = mysqli_query($db_connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[$row["CID"]][$row['CID']]["title"] = $row['Title'];
                    $data[$row["CID"]][$row['CID']]["max_attendees"] = $row['Max_attendees'];

                }
                foreach ($data as $courseKey => $courses) {
                    foreach ($courses as $cid => $course){
                        echo "<tr>";
                        echo "<td>{$courseKey}</td>";
                        echo "<td>{$course['title']}</td>";
                        echo "<td>" .count($courses) . " out of ";
                        echo "{$course['max_attendees']}" . " places booked</td>";
                       // echo "<td>{$courses['']}</td>";
                        echo "<td><button data-id='{$courseKey} 'class='btn bg-success text-white enrol'>Enrol</button></td>";
                        echo "</tr>";
                    }
                }
            }
            else {
                echo "0 results";
            }
            break;
        case "getUsersOnCourse":
            function userNumOnCourse($db_connect){
                // Show users on courses
                $sql = "SELECT * FROM `t_users` LEFT JOIN `t_courses` ON `t_users`.`Currentcourse` = `t_courses`.`Title` WHERE `Currentcourse` != 'None' ORDER BY `Currentcourse`;";
                $course = Null;
                $result = mysqli_query($db_connect, $sql);
                if (!$result) {
                    die(mysqli_error($db_connect));
                }
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[$row["Currentcourse"]][$row['UID']]["fname"] = $row['Fname'];
                    $data[$row["Currentcourse"]][$row['UID']]["lname"] = $row['Lname'];
                    $data[$row["Currentcourse"]][$row['UID']]["job"] = $row['Jobtitle'];
                }
                foreach ($data as $courseKey => $courseUsers) {
                    echo "<table class='table table-hover'>";
                    echo "<div class='row'><div class='col-md-12 d-flex'><h3>{$courseKey}</h3>";
                    echo "<p class='ml-auto counter'>" . count($courseUsers) ." People In This Course</p></div></div>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th scope='col'>UID</th>";
                    echo "<th scope='col'>First name</th>";
                    echo "<th scope='col'>Last name</th>";
                    echo "<th scope='col'>Job</th>";
                    echo "<th scope='col' id='remove'>Remove</th>";
                    echo "</tr>";
                    echo "</thead>";
                    echo "<tbody class='removeUserBody ${courseKey}Course'>";
                    foreach ($courseUsers as $uid => $user){
                        echo "<tr>";
                        echo "<td>{$uid}</td>";
                        echo "<td>{$user['fname']}</td>";
                        echo "<td>{$user['lname']}</td>";
                        echo "<td>{$user['job']}</td>";
                        echo "<td><button data-id='{$uid}'class='btn bg-danger text-white remove'>Remove from course</button></td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                }
            }
            userNumOnCourse($db_connect);
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
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                    // Preventation of deleting owner account
                    if ($id==1){
                        die("You cannot delete this account");
                    }
                    elseif ($id > 0){
                        // Check record exists
                        $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_users` WHERE `t_users`.`UID`=" . $id);
                        $totalrows = mysqli_num_rows($checkRecord);
                        if ($totalrows > 0){
                            // Delete record
                            $query = "DELETE FROM `t_users` WHERE `t_users`.`UID`=" . $id;
                            mysqli_query($db_connect, $query);
                            echo "Record successfully deleted";
                            exit;
                        }else{
                            echo "Record unsuccessfully deleted";
                            exit;
                        }
                   }
                }
                break;
            // Get course data
            case "deleteCourse":
                //Set id to correct UID
                $id = 0;
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                    if ($id > 0){
                        // Check record exists
                        $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_courses` WHERE `t_courses`.`CID`=" . $id);
                        $totalrows = mysqli_num_rows($checkRecord);
                        if ($totalrows > 0){
                            // Delete record
                            $query = "DELETE FROM `t_courses` WHERE `t_courses`.`CID`=" . $id;
                            mysqli_query($db_connect, $query);
                            echo "Record successfully deleted";
                            exit;
                        }else{
                            echo "Record unsuccessfully deleted";
                            exit;
                        }
                    }
                }
                break;
            // save user data
            case "accessSelector":
                function accessValF($db_connect, $auth){
                    if ($auth == "user"){
                        // Don't give option to change access level
                        echo "user";
                    }
                    else if ($auth == "admin"){
                        echo "admin";
                    }
                    else if ($auth == "owner"){
                        $query = "SELECT DISTINCT `Access` FROM `t_users`;";
                        $run = mysqli_query($db_connect, $query);
                        if (mysqli_num_rows($run) > 0) {
                            // Get Course current value
                            $access = $_POST["accessVal"];
                            $course_options ="";
                            while ($result = mysqli_fetch_assoc($run)){
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
                    else {
                        die("You do not have permission for this page");
                    }
                }
                accessValF($db_connect, $auth);
                break;
            case "saveUser":
                //Set id to correct UID
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                    // Preventation of editing owner account
                    if ($id == 1){
                        die("You cannot edit this account");
                    }elseif ($id > 0){
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
                        if ($totalrows > 0){
                            // edit record
                            $sqlQuery = "UPDATE `t_users` SET `Fname` = '$fname', `Lname` = '$lname', `Jobtitle` = '$job', `Email` = '$email', `Access` = '$access', `Currentcourse` = '$course' WHERE `t_users`.`UID` = '$id';";
                            mysqli_query($db_connect, $sqlQuery);
                            // Function to insert a new record to enrolment table
                            function updateEnrolmentTable($db_connect, $id, $cid, $course){
                                $checker = mysqli_query($db_connect,"SELECT * FROM `t_enrolment` WHERE `t_enrolment`.`UID`=$id;");
                                $rowChecker = mysqli_num_rows($checker);
                                if ($rowChecker > 0){
                                    if ($course == "None"){
                                        $sql = "DELETE FROM `t_enrolment` WHERE `t_enrolment`.`UID` = '$id';";
                                        mysqli_query($db_connect, $sql);
                                    }else{
                                        $sql ="UPDATE `t_enrolment` SET `UID` = `UID`, `CID` = '$cid' WHERE `t_enrolment`.`UID` = $id;";
                                        mysqli_query($db_connect, $sql);
                                        }
                                }
                                else{
                                    $sql = "INSERT INTO `t_enrolment`(`EID`, `UID`, `CID`) VALUES('". rand(). "', '$id', '$cid');";
                                    mysqli_query($db_connect,$sql);
                                }
                            }
                                updateEnrolmentTable($db_connect, $id, $cid, $course);
                                echo "Record updated successfully";
                            }else{
                                echo "Update failed, no records found.";
                                }
                        }
                }
                break;
            // save course data
            case "saveCourse":
                //Set id to correct UID
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                    if (isset($id)){
                        // Check record exists
                        $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_courses` WHERE `t_courses`.`CID`= $id;");
                        $totalrows = mysqli_num_rows($checkRecord);
                        $title = $_POST['title'];
                        $date = $_POST['date'];
                        $duration = $_POST['duration'];
                        $description = $_POST['description'];
                        $attendees = $_POST['attendees'];
                        if ($totalrows > 0){
                            // edit record
                            $sqlQuery = "UPDATE `t_courses` SET `Title` = '$title', `Date` = '$date', `Duration` = '$duration', `Description` = '$description', `Max_Attendees` = '$attendees' WHERE `CID` = $id;";
                            mysqli_query($db_connect, $sqlQuery);
                            echo "Record updated successfully";
                        }else{
                            echo "Update failed, no records found.";
                        }
                    }
                }else{
                    echo "Failed to update record: No ID!";
                }
                break;
            case "insertUser":
                if (isset($_POST['email'])){
                    $email = mysqli_real_escape_string($db_connect, $_POST['email']);
                    if ($email == ""){
                        die("your email is empty somehow");
                    }
                    else{
                        if (isset($email)){
                            $id = rand();
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
                            echo "Record INSERTED successfully";
                            // Function to insert a new record to enrolment table
                            function insertEnrolmentTable($db_connect, $id, $cid){
                                $sql = "INSERT INTO t_enrolment (UID, CID) VALUES ($id, $cid);";
                                mysqli_query($db_connect, $sql);
                            }
                            insertEnrolmentTable($db_connect, $id, $cid);
                        }
                    }
                }else{
                    echo "Failed to update record: No ID!";
                }
                break;
            case "insertCourse":
                if (isset($_POST['title']))
                {
                    $title = mysqli_real_escape_string($db_connect, $_POST['title']);
                    if (isset($title)){
                        // Check record exists
                        $id = rand();
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
                }else{
                    echo "Failed to update record: No ID!";
                }
                break;
            case "enrolOnCourse":
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    if (isset($id)){
                        $sql = "SELECT `Title`, `Max_attendees` FROM `t_courses` WHERE `CID` = '$id';";
                        $result = mysqli_query($db_connect, $sql);
                         while($row = mysqli_fetch_assoc($result)){
                             $title = $row["Title"];
                             $attendees = $row["Max_attendees"];
                         }
                         // Check to see if course is full
                        function counter($db_connect, $title){
                            $sql = "SELECT COUNT(`Currentcourse`) as num FROM `t_users` WHERE `Currentcourse` = '$title';";
                            $result = mysqli_query($db_connect, $sql);
                             while($row = mysqli_fetch_assoc($result)){
                                 $count = $row["num"];
                             }
                                return $count;
                        }
                        counter($db_connect, $title);
                        $countNum = counter($db_connect, $title);
                        if ($countNum >= $attendees)
                        {
                            echo "Course is full. You cannot enrol on this.";
                        }else{
                            // Function to insert a new record to enrolment table
                            function enrolmentTable($db_connect, $id){
                                $sql = "INSERT INTO `t_enrolment` (`EID`,`UID`, `CID`) VALUES (`EID`, '" . $_SESSION['userid']  ."', '$id');";
                                mysqli_query($db_connect, $sql);
                            }
                            enrolmentTable($db_connect, $id);
                            // Function to change current course to one just clicked
                            function userCourse($db_connect, $id){
                                $sql = "UPDATE `t_users` SET `Currentcourse` = (SELECT `Title` FROM `t_courses` WHERE `CID` = '$id') WHERE `UID` = '" . $_SESSION['userid'] . "';";
                                mysqli_query($db_connect, $sql);
                            }
                            userCourse($db_connect, $id);
                            echo "Records updated successfully";
                        }
                    }
                    else{
                        echo "no ID set!";
                    }
                }else{
                    die($_POST['id']);
                }
                break;
            case "removeUserFromCourse":
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    if (isset($id)){
                        function removeUser($db_connect, $id){
                            $sql="UPDATE `t_users` SET `Currentcourse` = 'None' WHERE `UID` = '$id';";
                            mysqli_query($db_connect, $sql);
                        }
                        removeUser($db_connect, $id);
                        function removeEnrolment($db_connect, $id){
                            $sql="DELETE FROM `t_enrolment` WHERE `t_enrolment`.`UID` = '$id';";
                            mysqli_query($db_connect, $sql);
                        }
                        removeEnrolment($db_connect, $id);
                        echo "Records updated successfully";
                    }else{
                        die("No ID set!");
                    }
                }
                break;
        }
    }else{
        die("No case set");
    }
