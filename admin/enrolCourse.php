 <?php
require_once("_loginCheck.php");
    if ($auth == "admin" || $auth == "user") {
?>
<div class='table-responsive'>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th scope='col'>CID</th>
                <th scope='col'>Title</th>
                <th scope='col' id='enrol'>Enrol</th>

            </tr>
        </thead>
        <tbody class="courseEnrolTable"></tbody>
    </table>
</div>
<script type="text/javascript">
        function getEnrolCourseData() {
            const getEnrolCourse = "getEnrolCourse";
            $.ajax({
                url: 'cases.php',
                type: 'GET',
                data: {
                    case: getEnrolCourse
                }

            }).done(function(response) {
                $('.courseEnrolTable').html(response);
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