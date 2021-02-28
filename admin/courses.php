<?php 
    include_once("_logincheck.php");
// If admin then display course table and allow deletion of course also display
    if ($auth == "admin")
        {
            echo "
                <div class='table-responsive'>
                    <table class='table table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>CID</th>
                                <th scope='col'>Title</th>
                                <th scope='col'>Date</th>
                                <th scope='col'>Duration</th>
                                <th scope='col'>Description</th>
                                <th scope='col'>Max Attendees</th>
                                <th scope='col'>Time</th>
                                <th scope='col'>Delete</th>
                            </tr>
                        </thead>";
include_once("connect.php");
// Select all users from database
$query = "SELECT * FROM `t_courses`";
$run = mysqli_query($db_connect,$query);
$result =  mysqli_fetch_assoc($run);
        while ($result = mysqli_fetch_assoc($run))
            {
            //Display Courses in rows

                echo "
                    <tbody>
                        <tr>
                        <td>$result[CID]</td>
                        <td>$result[Title]</td>
                        <td>$result[Date]</td>
                        <td>$result[Duration]</td>
                        <td>$result[Description]</td>
                        <td>$result[Max_attendees]</td>
                        <td>$result[Timestamp]</td>
                        <td><a href='#' class='hi'>Delete:</a></td></tr>
                    </tbody>
                    ";
            }
        echo "</table></div>";
        }
    else if($auth = "user")
    {
         echo "
         <h2>This currently displays the user table again as I have not set up the view courses page for users</h2>
            <div class='table-responsive'>
                <table class='table table-hover'>
                    <thead>
                        <tr>
                            <th scope='col'>UID</th>
                            <th scope='col'>Email</th>
                            <!--<th scope='col'>Password</th>-->
                            <th scope='col'>Fname</th>
                            <th scope='col'>Lname</th>
                            <th scope='col'>Access Level</th>
                            <th scope='col'>Current Course</th>
                            <th scope='col'>Time</th>
                        </tr>
                </thead>";
include_once("connect.php");
// Select all users from database
$query = "SELECT * FROM `t_users`";
$run = mysqli_query($db_connect,$query);
$result =  mysqli_fetch_assoc($run);
        while ($result = mysqli_fetch_assoc($run))
            {
            //Display users in rows
          //  $jsonobj = json_encode($result['UID']);
            
                echo "
                    <tbody>
                        <tr>
                            <td>$result[UID]</td>
                            <td>$result[Email]</td>
                            <!--<td>$result[Password]</td>-->
                            <td>$result[Fname]</td>
                            <td>$result[Lname]</td>
                            <td>$result[Access]</td>
                            <td>$result[Currentcourse]</td>
                            <td>$result[Timestamp]</td>
                        </tr>
                    </tbody>";

        }
        echo "</table></div>";
    }
    else 
        {
        header("Location:../index.php");
        die("Access denied");
        }
