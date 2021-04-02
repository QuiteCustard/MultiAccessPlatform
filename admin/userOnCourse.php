<?php
include_once("_logincheck.php");
    if ($auth == "admin") {
?>
<div class='table-responsive tUserCourse'></div>
<script type="text/javascript">
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
    getEnrolCourseData();
    //Enrol
    $('body').off('click', '.remove').on('click', '.remove', function(e) {
        const removeButton = $(e.target);
        const removeUserFromCourse = "removeUserFromCourse";
        var removeid = $(this).data('id');
        // Log course being created
        console.log('REMOVING from course');
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
                console.log(response);
                getEnrolCourseData();
            });
        }
    });

</script>
<?php
    }
