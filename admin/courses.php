<?php 
include_once("_logincheck.php");
// Check to ensure only admin accounts can access
if ($auth == "admin") {
  //Table headers
  ?>
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
                <th scope='col' id='delete'>Delete</th>
            </tr>
        </thead>
        <tbody class="courseTable"></tbody>
    </table>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        function getData() {
            console.log('running data...');
            $.ajax({
                url: 'getCourse.php',
                type: 'GET',
            }).done(function(response) {
                console.log('response', response);
                $('.courseTable').html(response);
            });
        }

        getData();

        // Delete
        $('body').on('click', '.delete', function() {
            console.log('DELETE');
            // Delete id
            var deleteid = $(this).data('id');
            console.log('DELETE', deleteid);
            // AJAX Request
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {
                    id: deleteid
                }
            }).done(function(response) {
                console.log(response);
                getData();
            });
        });

        setInterval(getData, 1000);
    });

</script>
<?php
}
    // If not admin then display
    elseif($auth == "user")
{
        ?>
<h1>Currently displays user table as have not sorted user courses</h1>
<div class='table-responsive'>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th scope='col'>UID</th>
                <th scope='col'>Email</th>
                <!--<th scope='col'>Password</th>-->
                <th scope='col'>Fname</th>
                <th scope='col'>Lname</th>
                <th scope='col'>Job title</th>
                <th scope='col'>Access Level</th>
                <th scope='col'>Current Course</th>
                <th scope='col'>Time</th>
                <th scope='col' id='delete'>Delete</th>
            </tr>
        </thead>
        <tbody class="userTable"></tbody>
    </table>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        function getData() {
            console.log('running data...');
            $.ajax({
                url: 'getUser.php',
                type: 'GET',
            }).done(function(response) {
                console.log('response', response);
                $('.userTable').html(response);
            });
        }

        getData();

        // Delete
        $('body').on('click', '.delete', function() {
            console.log('DELETE');
            // Delete id
            var deleteid = $(this).data('id');
            console.log('DELETE', deleteid);
            // AJAX Request
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {
                    id: deleteid
                }
            }).done(function(response) {
                console.log(response);
                getData();
            });
        });

        setInterval(getData, 1000);
    });

</script>

<?php
        }
else {
header("Location:../index.php");
echo "Please enter admin credentials";
die("access denied");
};
