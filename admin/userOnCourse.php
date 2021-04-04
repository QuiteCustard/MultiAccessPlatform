<?php
// Check to ensure only logged in accounts can access this page
require_once("_logincheck.php");
    if ($auth == "admin" || $auth == "owner") {
?>
<div class='row'>
    <div class='col-md-10'>
        <h3>Courses</h3>
    </div>
    <div class='col-md-2'>
        <input type="text" id="search" class="form-control primary inputs" placeholder="Search.." />
        <p class="text-center">You can search by all rows</p>
    </div>
</div>
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
        // User search
        function userSearch() {
            // Update data after every key press
            $('#search').on('keyup', function() {
                const input = $("#search");
                const filter = input.val().toUpperCase();
                const table = $(".removeUserBody");
                const tr = table.find("tr");
                for (i = 0; i < tr.length; i++) {
                    // Find all tds
                    tds = $(tr[i]).find("td");
                    // Set found to false so I can update styles later if results are found/not
                    var found = false;
                    // Set all tds to be searchable
                    for (j = 0; j < tds.length; j++) {
                        td = tds[j];
                        if (td) {
                            if (td.innerText.toUpperCase().indexOf(filter) > -1) {
                                found = true;
                                break;
                            }
                        }
                    }
                    // Styles
                    if (found) {
                        tr[i].style.display = "";
                        $(tr[i]).addClass("tertiarySelect");

                    } else {
                        tr[i].style.display = "none";
                        $(tr[i]).removeClass("tertiarySelect");
                    }
                }
            });
        };
        userSearch();
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
