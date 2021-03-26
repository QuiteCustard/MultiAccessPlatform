<?php
require_once ("connect.php");
session_start();
if (isset($_GET['case']))
{
    $case = $_GET['case'];
    switch ($case)
    {
            // Get user data

        case "getUserData":
$query = "SELECT * FROM `t_users`";
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
        echo "<td class='courseResult'>".$row['Currentcourse']."</td>";
        echo "<td>".$row['Timestamp']."</td>";
        echo "<td><button data-id='".$row['UID']."'class='btn bg-warning text-white edit'>Edit</button></td>";
        echo "<td><button data-id='".$row['UID']."'class='btn bg-danger text-white delete'>Delete</button></td>";
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
        echo "<td><button data-id='".$row['CID']."'class='btn bg-warning text-white edit'>Edit</button></td>";
        echo "<td><button data-id='".$row['CID']."'class='btn bg-danger text-white delete'>Delete</button></td>";
        echo"</tr>";
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
            case "editUser":
            $query = "SELECT `Title` FROM `t_courses`";
            $run = mysqli_query($db_connect, $query);
            $result = mysqli_fetch_assoc($run);
            $course_options ="";
            while ($result = mysqli_fetch_assoc($run))
            {
                 //Display users in rows
                $title = $result["Title"];
                $course_options .= "<option value='$title'>$title</option>";
            }
            echo $course_option = '<select class="form-control form-control-user primary" id="course" name="course_option">'.$course_options.'</select>';
                break;
            case "saveUser":
                //Set id to correct UID
                if (isset($_POST['id']))
                {
                    $id = mysqli_real_escape_string($db_connect, $_POST['id']);
                }
                if (isset($id))
                {
                    // Check record exists
                    $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_users` WHERE `t_users`.`UID`=" . $id);
                    $totalrows = mysqli_num_rows($checkRecord);
                    $email = $_POST['email'];
                    $fname = $_POST['fname'];
                    $lname = $_POST['lname'];
                    $job = $_POST['job'];
                    $access = $_POST['access'];
                    $course = $_POST['course'];
                    if ($totalrows > 0)
                    {
                        // edit record
                        $sqlQuery = "UPDATE `t_users` SET `Fname` = '$fname', `Lname` = '$lname', `Jobtitle` = '$job', `Email` = '$email', `Access` = '$access', `Currentcourse` = '$course' WHERE `t_users`.`UID` = $id;";
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
                    $checkRecord = mysqli_query($db_connect, "SELECT * FROM `t_courses` WHERE `t_courses`.`CID`=" . $id);
                    $totalrows = mysqli_num_rows($checkRecord);
                    $title = $_POST['title'];
                    $date = $_POST['date'];
                    $duration = $_POST['duration'];
                    $description = $_POST['description'];
                    $attendees = $_POST['attendees'];
                    if ($totalrows > 0)
                    {
                        // edit record
                        $sqlQuery = "UPDATE `t_courses` SET `Title` = '$title', `Date` = '$date', `Duration` = '$duration', `Max_Attendees` = '$attendees' WHERE `CID` = $id;";
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

                    // Insert new record
                    $sqlQuery = "INSERT INTO `t_users` (`UID`, `Fname`, `Lname`, `Jobtitle`, `Email`, `Password`, `Access`, `Currentcourse`, `Attempts`, `Timestamp`, `Serial`) VALUES ('$id', '$fname', '$lname', '$job', '$email', '$password', '$access', '$course', '0', current_timestamp(), NULL);";
                    mysqli_query($db_connect, $sqlQuery);
                    echo "Record updated successfully";

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
               // die("die at case");
                if (isset($_POST['id']))
                {
                    $id = json_decode($userid);
                }
                if (isset($id))
                {
                   $courses_sql = "INSERT INTO t_enrolment (UID, CID) VALUES (" . $_SESSION['userid']  ." , $id);";

                   // $sqlQuery = "UPDATE `t_users` SET `Currentcourse` = '$course' WHERE `t_users`.`UID` = $id;";
                    mysqli_query($db_connect, $courses_sql);
                    echo "Record updated successfully";

                }
                else
                {
                    echo "Failed to update record: No ID!";
                }
                exit;
            break;
        }

    }
    else
    {
        echo "No case set";
        die();
    }
