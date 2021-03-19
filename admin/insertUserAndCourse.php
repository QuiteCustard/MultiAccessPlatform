<main class="container-fluid">
    <div class="row">
        <div class="col-sm">
            <!-- Add user table -->
            <h2 class="insertHeaders">Insert User</h2>
            <form class="user insertUserForm">
                <div class="form-group">
                    <label for="emailInput">Email:</label>
                    <input type="email" class="form-control form-control-user primary" id="emailInput" placeholder="Enter Email Address..." required>
                </div>
                <div class="form-group">
                    <label for="passwordInput">Password:</label>
                    <input type="password" class="form-control form-control-user primary" id="passwordInput" placeholder="Enter password..." required>
                </div>
                <div class="form-group">
                    <label for="fnameInput">First name:</label>
                    <input type="text" class="form-control form-control-user primary" id="fnameInput" placeholder="Enter first name..." required>
                </div>
                <div class="form-group">
                    <label for="lnameInput">Last name:</label>
                    <input type="text" class="form-control form-control-user primary" id="lnameInput" placeholder="Enter last name..." required>
                </div>
                <div class="form-group">
                    <label for="jobInput">Job title:</label>
                    <input type="text" class="form-control form-control-user primary" id="jobInput" placeholder="Enter job title..." required>
                </div>
                <div class="form-group">
                    <label for="accessInput">Access level for application:</label>
                    <input type="text" class="form-control form-control-user primary" id="accessInput" placeholder="Enter access level..." required>
                </div>
                <div class="form-group">
                    <label for="courseInput">Current course:</label>
                    <input type="text" class="form-control form-control-user primary" id="courseInput" placeholder="Enter course..." required>
                    <small id="courseHelp" class="form-text text-muted">If the user is not currently enrolled on a course, please input "none".</small>
                </div>

                <a href="#" class="btn btn-success btn-user btn-block saveUser">
                    Save
                </a>
                <a href="#" class="btn btn-danger btn-user btn-block clearUser">
                    Clear
                </a>
            </form>
        </div>
        <div class="col-sm">
            <!-- Add course table -->
            <h2 class="insertHeaders">Insert Course</h2>
            <form class="user insertCourseForm">
                <div class="form-group">
                    <label for="titleInput">Course Title:</label>
                    <input type="text" class="form-control form-control-user primary" id="titleInput" placeholder="Enter course title ..." required>
                </div>
                <div class="form-group">
                    <label for="dateInput">Course start date:</label>
                    <input type="text" class="form-control form-control-user primary" id="dateInput" placeholder="Enter date..." required>
                </div>
                <div class="form-group">
                    <label for="durationInput">Course duration:</label>
                    <input type="text" class="form-control form-control-user primary" id="durationInput" placeholder="Enter course duration..." required>
                </div>
                <div class="form-group">
                    <label for="descriptionInput">Course description:</label>
                    <input type="text" class="form-control form-control-user primary" id="descriptionInput" placeholder="Enter course description..." required>
                </div>
                <div class="form-group">
                    <label for="attendeesInput">Course max attendees:</label>
                    <input type="text" class="form-control form-control-user primary" id="attendeesInput" placeholder="Enter max attendees..." required>
                </div>
                <div class="form-group">
                    <a href="#" class="btn btn-success btn-user btn-block saveCourse">
                        Save
                    </a>
                    <a href="#" class="btn btn-danger btn-user btn-block clearCourse">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
</main>

<!-- Jquery Ajax to post user data -->
<script type="text/javascript">
    $(document).ready(function() {
        // User
        // Save user
        $('body').on('click', '.saveUser', function(e) {
            const saveButton = $(e.target);
            var email = $('#emailInput').val();
            var password = $('#passwordInput').val();
            var fname = $('#fnameInput').val();
            var lname = $('#lnameInput').val();
            var job = $('#jobInput').val();
            var access = $('#accessInput').val();
            var course = $('#CourseInput').val();
            // Log user being created
            console.log('SAVING NEW USER ', email);
            // AJAX Request
            $.ajax({
                url: 'insertUser.php',
                type: 'POST',
                data: {
                    email: email,
                    fname: fname,
                    lname: lname,
                    job: job,
                    access: access,
                    course: course
                }
            }).done(function(response) {
                $('.insertUserForm').trigger("reset");
            });
        });
        //Clear user form
        $('body').on('click', '.clearUser', function(e) {
            $('.insertUserForm').trigger("reset");
        });

        // Course
        // Save course
        $('body').on('click', '.saveCourse', function(e) {
            const saveButton = $(e.target);
            var title = $('#titleInput').val();
            var date = $('#dateInput').val();
            var duration = $('#durationInput').val();
            var description = $('descriptionInput').val();
            var attendees = $('#attendeesInput').val();
            // Log course being created
            console.log('SAVING NEW Course ', title);
            // AJAX Request
            $.ajax({
                url: 'insertCourse.php',
                type: 'POST',
                data: {
                    title: title,
                    date: date,
                    duration: duration,
                    description: description,
                    attendees: attendees
                }
            }).done(function(response) {
                $('.insertCourseForm').trigger("reset");
            });
        });

        //Clear course form
        $('body').on('click', '.clearCourse', function(e) {
            $('.insertCourseForm').trigger("reset");
        });
    });

</script>
