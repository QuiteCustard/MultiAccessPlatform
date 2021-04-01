<?php
include_once("_logincheck.php");
    if ($auth == "admin") {
?>
<div class='table-responsive tUserCourse'></div>
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
                $('.tUserCourse').html(response);
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

