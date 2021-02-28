<?php 
include_once("_logincheck.php");
// Check to ensure only admin accounts can access
if ($auth == "admin")
{
//Table headers
    echo "
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
                        <th scope='col'>Delete</th>
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
                            <td><a href='#' class='hi'>Delete:</a></td>
                        </tr>
                    </tbody>";
            } 
    echo "</table></div>";
}
else
{
header("Location:../index.php");
       echo "Please enter admin credentials";
die("access denied");
}

