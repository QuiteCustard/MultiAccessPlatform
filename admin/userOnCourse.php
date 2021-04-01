<?php
include_once("_logincheck.php");
    if ($auth == "admin") {
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
                <?php
    if ($auth == "admin") {
        // Check to ensure only admin accounts can access
  ?>

                <th scope='col' id='edit'>Edit</th>
                <th scope='col' id='delete'>Delete</th>
                <?php
    }
    ?>
            </tr>
        </thead>
        <tbody class="usersOnCourseTable"></tbody>
    </table>
</div>
<script type="text/javascript">
        function getEnrolCourseData() {
            const getUserOnCourse = "getUserOnCourse";
            $.ajax({
                url: 'cases.php',
                type: 'GET',
                data: {
                    case: getUserOnCourse
                }

            }).done(function(response) {
                $('.usersOnCourseTable').html(response);
            });
        }
        getEnrolCourseData();
        //Enrol
        $('body').off('click', '.enrol').on('click', '.enrol', function(e) {
            const enrolButton = $(e.target);
            const insertUserToCourse = "insertUserToCourse";
            var enrolid = $(this).data('id');
            // Log course being created
            console.log('ENROLING on course');
            var c = confirm("Are you sure you want to enrol on this course?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        id: enrolid,
                        case: insertUserToCourse
                    }
                }).done(function(response) {
                    console.log(response);
                });
            }
        });
</script>
<?php
    }

