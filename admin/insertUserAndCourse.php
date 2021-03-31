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
                    <div id="accessSelector"></div>
                </div>
                <div class="form-group">
                    <label for="courseInput">Current course:</label>
                    <div id="courseSelector"></div>
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
                    <input type="text" class="form-control form-control-user primary" id="titleInput" placeholder="Enter course title ..." required />
                </div>
                <div class="form-group">
                    <label for="dateInput">Course start date:</label>
                    <input type="text" id="datepicker" class="form-control form-control-user primary" placeholder="Enter start date..." />


                </div>
                <div class="form-group">
                    <label for="durationInput">Course duration:</label>
                    <input type="text" class="form-control form-control-user primary" id="durationInput" placeholder="Enter course duration..." required />
                </div>
                <div class="form-group">
                    <label for="descriptionInput">Course description:</label>
                    <input type="text" class="form-control form-control-user primary" id="descriptionInput" placeholder="Enter course description..." required />
                </div>
                <div class="form-group">
                    <label for="attendeesInput">Course max attendees:</label>
                    <input type="text" class="form-control form-control-user primary" id="attendeesInput" placeholder="Enter max attendees..." required />
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
        var picker = new Pikaday({
            field: $('#datepicker')[0]
        });
        // User
        function courseSelector() {
            const courseSelector = $('#courseSelector');
            const newCourseSelector = "courseSelector";
            const courseVal = "None";
            $.ajax({
                url: 'cases.php',
                type: 'POST',
                data: {
                    courseVal: courseVal,
                    case: newCourseSelector
                }
            }).done(function(response) {
                // Set result as input with data inside
                courseSelector.html(response);
            });
        }
        courseSelector();

        function accessSelector() {
            const accessSelector = $('#accessSelector');
            const newAccessSelector = "accessSelector";
            const accessVal = "None";
            $.ajax({
                url: 'cases.php',
                type: 'POST',
                data: {
                    accessVal: accessVal,
                    case: newAccessSelector
                }
            }).done(function(response) {
                // Set result as input with data inside
                accessSelector.html(response);
            });
        }
        accessSelector();
        $(document).on("change", "select", function() {
            $("option[value=" + this.value + "]", this)
                .attr("selected", true).siblings()
                .removeAttr("selected")
        });
        // Save user
        $('body').on('click', '.saveUser', function(e) {
            const saveButton = $(e.target);
            const insertUser = "insertUser";
            var email = $('#emailInput').val();
            var password = $('#passwordInput').val();
            var fname = $('#fnameInput').val();
            var lname = $('#lnameInput').val();
            var job = $('#jobInput').val();
            var access = $('#accessInput').val();
            var course = $('#CourseInput').val();
            var newUserCid = $('#courseSelect').find(":selected").data('cid');
            // Log user being created
            console.log('SAVING NEW USER ', email);
            var c = confirm("Are you sure you want create this user with the specified details?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        email: email,
                        fname: fname,
                        lname: lname,
                        job: job,
                        access: access,
                        course: course,
                        case: insertUser,
                        newUserCid: newUserCid
                    }
                }).done(function(response) {
                    $('.insertUserForm').trigger("reset");
                });
            }
        });
        //Clear user form
        $('body').on('click', '.clearUser', function(e) {
            $('.insertUserForm').trigger("reset");
        });

        // Course
        // Save course
        $('body').on('click', '.saveCourse', function(e) {
            const saveButton = $(e.target);
            const insertCourse = "insertCourse";
            var title = $('#titleInput').val();
            var date = $('#dateInput').val();
            var duration = $('#durationInput').val();
            var description = $('descriptionInput').val();
            var attendees = $('#attendeesInput').val();
            // Log course being created
            console.log('SAVING NEW Course ', title);
            var c = confirm("Are you sure you want create this course with the specified details?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        title: title,
                        date: date,
                        duration: duration,
                        description: description,
                        attendees: attendees,
                        case: insertCourse
                    }
                }).done(function(response) {
                    $('.insertCourseForm').trigger("reset");
                });
            }
        });

        //Clear course form
        $('body').on('click', '.clearCourse', function(e) {
            $('.insertCourseForm').trigger("reset");
        });
    });

</script>
