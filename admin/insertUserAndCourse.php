<?php
// Check to ensure only admin or owner accounts can access this page
    require_once("_logincheck.php");
    if ($auth == "admin" || $auth == "owner") {
?>
<main class="container-fluid">
    <div class="row">
        <div class="col-sm">
            <!-- Add user table -->
            <h2 class="insertHeaders">Insert User</h2>
            <form class="user insertUserForm">
                <div class="form-group">
                    <label for="emailInput">Email:</label>
                    <input type="email" class="form-control form-control-user primary" id="emailInput" name="email" placeholder="Enter Email Address..." required aria-describedby="emailInput"/>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password:</label>
                    <input type="password" class="form-control form-control-user primary" id="passwordInput" name="password" placeholder="Enter password..." required aria-describedby="passwordInput" />
                </div>
                <div class="form-group">
                    <label for="fnameInput">First name:</label>
                    <input type="text" class="form-control form-control-user primary" id="fnameInput" name="fname" placeholder="Enter first name..." required aria-describedby="fnameInput" />
                </div>
                <div class="form-group">
                    <label for="lnameInput">Last name:</label>
                    <input type="text" class="form-control form-control-user primary" id="lnameInput" name="lname" placeholder="Enter last name..." required aria-describedby="lnameInput" />
                </div>
                <div class="form-group">
                    <label for="jobInput">Job title:</label>
                    <input type="text" class="form-control form-control-user primary" id="jobInput" name="job" placeholder="Enter job title..." required aria-describedby="jobInput" />
                </div>
                <div class="form-group">
                    <label for="accessInput">Access level for application:</label>
                    <select type="text" class="form-control form-control-user primary selectors" id="accessSelect" name="access" required aria-describedby="accessInput">
                        <option default="default" value="pending">Pending</option>
                        <option value="user">user</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn btn-success btn-user btn-block" />
                    <input type="reset" value="Clear" class="btn btn-danger btn-user btn-block" />
                </div>
            </form>
        </div>
        <div class="col-sm">
            <!-- Add course table -->
            <h2 class="insertHeaders">Insert Course</h2>
            <form class="user insertCourseForm">
                <div class="form-group">
                    <label for="titleInput">Course Title:</label>
                    <input type="text" class="form-control form-control-user primary" id="titleInput" name="title" placeholder="Enter course title ..." required aria-describedby="titleInput" />
                </div>
                <div class="form-group">
                    <label for="dateInput">Course start date:</label>
                    <input type="text" id="datepicker" class="form-control form-control-user primary" name="date" placeholder="Enter start date..." aria-describedby="dateInput" />
                </div>
                <div class="form-group">
                    <label for="durationInput">Course duration:</label>
                    <input type="text" class="form-control form-control-user primary" id="durationInput" name="duration" placeholder="Enter course duration..." required aria-describedby="durationInput" />
                </div>
                <div class="form-group">
                    <label for="descriptionInput">Course description:</label>
                    <input type="text" class="form-control form-control-user primary" id="descriptionInput" name="description" placeholder="Enter course description..." required aria-describedby="descriptionInput" />
                </div>
                <div class="form-group">
                    <label for="attendeesInput">Course max attendees:</label>
                    <input type="text" class="form-control form-control-user primary" id="attendeesInput" name="attendees" placeholder="Enter max attendees..." required aria-describedby="attendeesInput" />
                </div>
                <div class="form-group">
                    <input type="submit" value="Submit" class="btn btn-success btn-user btn-block" />
                    <input type="reset" value="Clear" class="btn btn-danger btn-user btn-block" />
                </div>
            </form>
        </div>
    </div>
</main>
<div class="response"></div>
<!-- Jquery Ajax to post user data -->
<script type="text/javascript">
    $(document).ready(function() {
        const responseDiv = $(".response");
        var picker = new Pikaday({
            field: $('#datepicker')[0]
        });
        // User
        // Append "selected" to the correct option if it is selected
        $(document).on("change", "select", function() {
            $("option[value=" + this.value + "]", this).attr("selected", true).siblings().removeAttr("selected")
        });
        // Insert new user to db
        $(".insertUserForm").on("submit", function(e) {
            e.preventDefault();
            const insertUser = "insertUser";
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: 'cases.php',
                data: {
                    data: data,
                    case: insertUser
                }
            }).done(function(response) {
                responseDiv.html(response);
                $('.insertUserForm').get(0).reset();
            });
        });
        //Clear user form
        $('body').on('click', '.clearUser', function(e) {
            $('.insertUserForm').get(0).reset();
        });
        // Course
        // Insert new course to db
        $(".insertCourseForm").on("submit", function(e) {
            e.preventDefault();
            const insertCourse = "insertCourse";
            var data = $(this).serialize();
            $.ajax({
                type: "POST",
                url: 'cases.php',
                data: {
                    data: data,
                    case: insertCourse
                }
            }).done(function(response) {
                responseDiv.html(response);
                $('.insertCourseForm').get(0).reset();
            });

            //Clear course form
            $('body').on('click', '.clearCourse', function(e) {
                $('.insertCourseForm').get(0).reset();
            });
        });
    });
</script>
<?php
    }else{
        header("Location:../index.php");
        echo "Please enter admin credentials";
        die("access denied");
}
