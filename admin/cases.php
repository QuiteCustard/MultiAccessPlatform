<?php
// Don't allow to go forward without connection to db
require_once ("connect.php");
// Check that only specified access levels can access
require_once("_logincheck.php");
// Check whether a GET request or a POST request
if (isset($_GET['case']))
{
    $case = $_GET['case'];
    // Switch for all GET requests
    switch ($case)
    {
        // Get user data
        case "getUserData":
            // Confirm only admins+ can access everyones details
            if ($auth == "owner" || $auth == "admin"){
                // Set result to this query
                $result = $mysqli->query("SELECT * FROM t_users");
            }else{
                // Prepared statement
                $stmt = $mysqli->prepare("SELECT * FROM `t_users` WHERE UID = ?");
                // Put parameter into query
                $stmt->bind_param("i", $_SESSION['userid']);
                // Run the statement
                $stmt->execute();
                // Set result to this query
                $result = $stmt->get_result();
            }
            // Check row count
            if ($result->num_rows > 0) {
                // output data of each row
                while ($row = $result->fetch_assoc()) {
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
            $result = $mysqli->query("SELECT * FROM t_courses");
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
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
            }else {
                echo "0 results";
            }
            break;
        case "getEnrolCourse":
            // Select all courses from database
            $result = $mysqli->query("SELECT * FROM t_courses");
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $title = $row['Title'];
                    $cid = $row['CID'];
                    $attendee = $row['Max_attendees'];
                    $date = $row['Date'];
                    // Check to see if course is full
                    $count_sql = "SELECT `UID` FROM `t_users` WHERE `Currentcourse` = '$title';";
                    $count_result = mysqli_query($mysqli, $count_sql);
                    $countNum = mysqli_num_rows($count_result);
                    echo "<tr>";
                    echo "<td class='idResult'>$cid</td>";
                    echo "<td class='titleResult'>$title</td>";
                    echo "<td class='dateResult'>$date</td>";
                    echo "<td class='attendeesResult'>$countNum out of $attendee places booked</td>";
                    echo "<td><button data-id='$cid' class='btn bg-success text-white enrol'>Enrol</button></td>";
                    echo "</tr>";
                }
            }else{
                echo "0 results";
            }
            break;
        case "getUsersOnCourse":
            // Show users on courses
            $result = $mysqli->query("SELECT * FROM `t_users` LEFT JOIN `t_courses` ON `t_users`.`Currentcourse` = `t_courses`.`Title` WHERE `Currentcourse` != 'None' ORDER BY `Currentcourse`");
            $course = Null;
            if (!$result) {
                die(mysqli_error($mysqli));
            }
            while ($row = $result->fetch_assoc()){
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
                echo "<tbody class='removeUserBody'>";
                foreach ($courseUsers as $uid => $user){
                    echo "<tr>";
                    echo "<td>{$uid}</td>";
                    echo "<td>{$user['fname']}</td>";
                    echo "<td>{$user['lname']}</td>";
                    echo "<td>{$user['job']}</td>";
                    echo "<td><button data-id='{$uid}'class='btn bg-danger blackout text-white remove'>Remove from course</button></td>";
                    echo "</tr>";
                }
                echo "</table>";
            }
            break;
        }
    }
    // Check if POST request
    else if (isset($_POST['case']))
    {
        $case = $_POST['case'];
        // Switch for all POST requests
        switch ($case)
        {
            // delete user data
            case "deleteUser":
                $id = 0;
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                    // Preventation of deleting owner account
                    if ($id==1){
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>You cannot delete this user!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                        exit;
                    }
                    elseif ($id > 0){
                        // Prepared statement
                        $stmt = $mysqli->prepare("SELECT * FROM `t_users` WHERE UID = ?");
                        // Put parameter into query
                        $stmt->bind_param("i", $id);
                        // Run the statement
                        $stmt->execute();
                        // Set result to this query
                        $result = $stmt->get_result();
                        // Check record exists
                        if ($result->num_rows > 0){
                            // Delete record
                            $stmt = $mysqli->prepare("DELETE FROM `t_users` WHERE `t_users`.`UID` = ?");
                            // Put parameter into query
                            $stmt->bind_param("i", $id);
                            // Run statement
                            $stmt->execute();
                            // Close statement
                            $stmt->close();
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>User deleted!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>User not deleted!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }
                   }
                }
                break;
            // Get course data
            case "deleteCourse":
                //Set id to correct CID
                $id = 0;
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                    if ($id > 0){
                        // Prepared statement
                        $stmt = $mysqli->prepare("SELECT * FROM `t_courses` WHERE CID = ?");
                        // Put parameter into query
                        $stmt->bind_param("i", $id);
                        // Run the statement
                        $stmt->execute();
                        // Set result to this query
                        $result = $stmt->get_result();
                        // Check record exists
                        if ($result->num_rows > 0){
                            // Delete record
                            // Prepared statement
                            $stmt = $mysqli->prepare("DELETE FROM `t_courses` WHERE `t_courses`.`CID` = ?");
                            // Put parameter into query
                            $stmt->bind_param("i", $id);
                            // Run statement
                            $stmt->execute();
                            // Close statement
                            $stmt->close();
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Course deleted!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Course not deleted!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }
                    }
                }
                break;
            // save user data
            case "accessSelector":
                if ($auth == "user"){
                    // Don't give option to change access level
                    echo "user";
                }
                else if ($auth == "admin"){
                    echo "admin";
                }
                // Allow owner to change access levels
                else if ($auth == "owner" ){
                    $result = $mysqli->query("SELECT DISTINCT Access FROM t_users");
                    if ($result->num_rows > 0) {
                        // Get access current value
                        $accessVal = $_POST["accessVal"];
                        $access_options ="";
                        while ($row = $result->fetch_assoc()){
                            //Display access levels as options
                            $access = $row["Access"];
                            $access_options .= "<option value='$access'";
                            if ($access == $accessVal) {
                                $access_options .= "selected='selected'";
                            }
                            $access_options .= ">$access</option>";
                        }
                        $selectAccess = '<select class="form-control form-control-user primary selectors" id="access" name="access_option">' .$access_options.'</select>';
                        echo $selectAccess;
                    }
                }else {
                    die("You do not have permission for this page");
                }
                break;
            case "saveUser":
                //Set id to correct UID
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                    // Preventation of editing owner account
                    if ($id == 1){
                        die("You cannot edit this account");
                    }elseif ($id > 0){
                        // Prepared statement
                        $stmt = $mysqli->prepare("SELECT * FROM `t_users` WHERE UID = ?");
                        // Put parameter into query
                        $stmt->bind_param("i", $id);
                        // Run the statement
                        $stmt->execute();
                        // Set result to this query
                        $result = $stmt->get_result();
                        // Set variables
                        $email = $_POST['email'];
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $job = $_POST['job'];
                        $access = $_POST['access'];
                        if ($result->num_rows > 0){
                            // Prepared statement
                            $stmt = $mysqli->prepare("UPDATE `t_users` SET Email = ?, Fname = ?, Lname = ?, Jobtitle = ?, Access = ? WHERE UID = ?");
                            // Put parameters into query
                            $stmt->bind_param("sssssi", $email, $fname, $lname, $job, $access, $id);
                            // Run statement
                            $stmt->execute();
                            // Close statement
                            $stmt->close();
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>New details saved!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Details not saved!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                            }
                        }
                }
                break;
            // save course data
            case "saveCourse":
                //Set id to correct UID
                if (isset($_POST['id'])){
                    $id = mysqli_real_escape_string($mysqli, $_POST['id']);
                    if (isset($id)){
                        // Prepared statement
                        $stmt = $mysqli->prepare("SELECT * FROM `t_courses` WHERE `t_courses`.`CID` = ?");
                        // Put parameter into query
                        $stmt->bind_param("i", $id);
                        // Run the statement
                        $stmt->execute();
                        // Set result to this query
                        $result = $stmt->get_result();
                        // Set variables
                        $title = $_POST['title'];
                        $date = $_POST['date'];
                        $duration = $_POST['duration'];
                        $description = $_POST['description'];
                        $attendees = $_POST['attendees'];
                        // Check record exists
                        if ($result->num_rows > 0){
                            // Prepared statement
                            $stmt = $mysqli->prepare("UPDATE `t_courses` SET Title = ?, Date = ?, Duration = ?, Description = ?, Max_attendees = ? WHERE CID = ?");
                            // Put parameters into query
                            $stmt->bind_param("ssssii", $title, $date, $duration, $description, $attendees, $id);
                            // Run statement
                            $stmt->execute();
                            // Close statement
                            $stmt->close();
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>Course details updated!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Course details not updated!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                        }
                    }
                }else{
                    die("Failed to update record: No ID!");
                }
                break;
            case "insertUser":
                // Recieve data as array
                $data = array();
                // Parse array to strings
                parse_str($_POST['data'], $data);
                // Seperate array + set variables
                $email = $data['email'];
                $id = rand();
                $fname = $data['fname'];
                $lname = $data['lname'];
                $access = $data['access'];
                $job = $data['job'];
                $password = $data['password'];
                if (isset($email)){
                    // Prepared statement
                    $stmt = $mysqli->prepare("INSERT INTO `t_users` (`UID`, `Fname`, `Lname`, `Jobtitle`, `Email`, `Password`, `Access`) VALUES (?, ?, ?, ?, ?, ?, ?)");
                    // Put parameters into query
                    $stmt->bind_param("issssss", $id, $fname, $lname, $job, $email, $password, $access);
                    // Run statement
                    $stmt->execute();
                     // Close statement
                    $stmt->close();
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>New user added!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }else{
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>User not added. Check that all values are inputted!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
                break;
            case "insertCourse":
                 // Recieve data as array
                $data = array();
                // Parse array to strings
                parse_str($_POST['data'], $data);
                // Seperate array + set variables
                $title = $data['title'];
                $id = rand();
                $date = $data['date'];
                $duration = $data['duration'];
                $description = $data['description'];
                $attendee = $data['attendees'];
                if (isset($title)){
                     // Prepared statement
                    $stmt = $mysqli->prepare("INSERT INTO `t_courses` (`CID`, `Title`, `Date`, `description`, `Duration`, `Max_attendees`) VALUES (?, ?, ?, ?, ?, ?)");
                    // Put parameters into query
                    $stmt->bind_param("issssi", $id, $title, $date, $description, $duration, $attendee);
                    // Run statement
                    $stmt->execute();
                     // Close statement
                    $stmt->close();
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>New course added!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }else{
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>Course not added. Check that all values are inputted!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
                break;
            case "enrolOnCourse":
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    if (isset($id)){
                        // Prepared statement
                        $stmt = $mysqli->prepare("SELECT `Title`, `Max_attendees` FROM `t_courses` WHERE `CID` = ?");
                        // Put parameter into query
                        $stmt->bind_param("i", $id);
                        // Run the statement
                        $stmt->execute();
                        // Set result to this query
                        $result = $stmt->get_result();
                        // Check row count
                        if ($result->num_rows > 0) {
                            // output data of each row
                            while ($row = $result->fetch_assoc()) {
                                $title = $row["Title"];
                                $attendees = $row["Max_attendees"];
                            }
                        }
                            // Check to see if course is full
                            // Prepared statement
                            $stmt = $mysqli->prepare("SELECT `UID` FROM `t_users` WHERE `Currentcourse` = ?");
                            // Put parameter into query
                            $stmt->bind_param("s", $title);
                            // Run the statement
                            $stmt->execute();
                            // Set result to this query
                            $result = $stmt->get_result();
                            // Check row count
                            $countNum = $result->num_rows;
                        if ($countNum >= $attendees){
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>This course is full!</strong> You cannot enrol on this course!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                        }else{
                            // Insert a new record to enrolment table
                            // Prepared statement
                            $stmt = $mysqli->prepare("SELECT * FROM `t_enrolment` WHERE `t_enrolment`.`UID`= ?");
                            // Put parameter into query
                            $stmt->bind_param("i", $_SESSION['userid']);
                            // Run the statement
                            $stmt->execute();
                            // Set result to this query
                            $result = $stmt->get_result();
                            // Check row count
                            if (!($result->num_rows > 0)) {
                                $stmt = $mysqli->prepare("INSERT INTO `t_enrolment` (`UID`, `CID`) VALUES (?, ?)");
                                // Put parameters into query
                                $stmt->bind_param("ii", $_SESSION['userid'] , $id);
                                // Run statement
                                $stmt->execute();
                                 // Close statement
                                $stmt->close();
                                }else{
                                    // Prepared statement
                                    $stmt = $mysqli->prepare("UPDATE `t_enrolment` SET CID = ? WHERE t_enrolment.UID = ?");
                                    // Put parameters into query
                                    $stmt->bind_param("ii", $id, $_SESSION['userid']);
                                    // Run statement
                                    $stmt->execute();
                                    // Close statement
                                    $stmt->close();
                                }
                                // Change current course to one just clicked
                                // Prepared statement
                                $stmt = $mysqli->prepare("UPDATE `t_users` SET `Currentcourse` = (SELECT `Title` FROM `t_courses` WHERE `CID` = ?) WHERE `UID` = ?");
                                // Put parameters into query
                                $stmt->bind_param("si", $id, $_SESSION['userid']);
                                // Run statement
                                $stmt->execute();
                                // Close statement
                                $stmt->close();
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>You have enrolled on this course!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                        }
                    }else{
                        die("no ID set!");
                    }
                }else{
                    die("no ID set!");
                }
                break;
            case "removeUserFromCourse":
                if (isset($_POST['id'])){
                    $id = $_POST['id'];
                    $val = "None";
                    if (isset($id)){
                        $stmt = $mysqli->prepare("UPDATE `t_users` SET `Currentcourse` = ? WHERE `t_users`.`UID` = ?");
                        // Put parameters into query
                        $stmt->bind_param("si", $val, $id);
                        // Run statement
                        $stmt->execute();
                        // Close statement
                        $stmt->close();
                        // Delete record
                        // Prepared statement
                        $stmt = $mysqli->prepare("DELETE FROM `t_enrolment` WHERE `t_enrolment`.`UID` = ?");
                        // Put parameter into query
                        $stmt->bind_param("i", $id);
                        // Run statement
                        $stmt->execute();
                        // Close statement
                        $stmt->close();
                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><strong>User removed from course!</strong> The performed action was successful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                        exit;
                        }else{
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><strong>User not removed!</strong> The performed action was unsuccessful!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                            exit;
                    }
                }
                else{
                    die("No ID set!");
                }
                break;
        }
    }else{
        die("No case set");
    }