<?php
// Check to ensure only logged in accounts can access this page
require_once("_logincheck.php");
    if ($auth == "admin" || $auth == "owner" || $auth == "user") {
?>
<div class='table-responsive tUserCourse'></div>
<div class="response"></div>
<script>
    $(document).ready(function() {
        const responseDiv = $(".response");

        function getEnrolCourseData() {
            const getUsersOnCourse = "getUsersOnCourse";
            $.ajax({
                url: 'cases.php',
                type: 'GET',
                data: {
                    case: getUsersOnCourse
                }
            }).done(function(response) {
                $('.tUserCourse').html(response);
            });
        }
        var intervalTiming = setInterval(getEnrolCourseData(), 60000);
        // Remove user from course
        $('body').off('click', '.remove').on('click', '.remove', function(e) {
            const removeButton = $(e.target);
            const removeUserFromCourse = "removeUserFromCourse";
            var removeid = $(this).data('id');
            // Log course being created
            var c = confirm("Are you sure you want to remove this user from this course?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        id: removeid,
                        case: removeUserFromCourse
                    }
                }).done(function(response) {
                    responseDiv.html(response);
                    getEnrolCourseData();
                });
            }
        });
    });

</script>
<?php
}   else{
        header("Location:../index.php");
        echo "Please enter admin credentials";
        die("access denied");
}
