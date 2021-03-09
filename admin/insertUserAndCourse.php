<!-- Add user table -->
<h2 class="">Insert User</h2>

<form class="user insertForm">
    <div class="form-group">
        <input type="email" class="form-control form-control-user emailInput" placeholder="Enter Email Address..." required>
    </div>
    <div class="form-group">
        <input type="password" class="form-control form-control-user passwordInput" placeholder="Enter password..." required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user fnameInput" placeholder="Enter first name..." required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user lnameInput" placeholder="Enter last name..." required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user jobInput" placeholder="Enter job title..." required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user accessInput" placeholder="Enter access level..." required>
    </div>
    <div class="form-group">
        <input type="text" class="form-control form-control-user courseInput" placeholder="Enter course..." required>
    </div>

    <a href="#" class="btn btn-success btn-user btn-block save">
        Save
    </a>
    <a href="#" class="btn btn-danger btn-user btn-block clear">
        Clear
    </a>
</form>

<!-- Jquery Ajax to post user data -->
<script type="text/javascript">
    $(document).ready(function() {
        // Save
        $('body').on('click', '.save', function(e) {
            const saveButton = $(e.target);
            var email = $('.EmailInput').val();
            var password = $('.passwordInput').val();
            var fname = $('.fnameInput').val();
            var lname = $('.lnameInput').val();
            var job = $('.jobInput').val();
            var access = $('.accessInput').val();
            var course = $('.CourseInput').val();

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

            });
        });

        //Clear form
        $('body').on('click', '.clear', function(e) {
            $('.insertForm').trigger("reset");
        });
    });

</script>
