<?php 
include_once("_logincheck.php");
// Check to ensure only admin accounts can access this page
if ($auth == "admin") {
  ?>
<!-- Table headers-->
<div class='table-responsive'>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th scope='col'>UID</th>
                <th scope='col'>Email</th>
                <!--<th scope='col'>Password</th>-->
                <th scope='col'>Fname</th>
                <th scope='col'>Lname</th>
                <th scope='col'>Job title</th>
                <th scope='col'>Access Level</th>
                <th scope='col'>Current Course</th>
                <th scope='col'>Time</th>
                <th scope='col' id='edit'>Edit</th>
                <th scope='col' id='delete'>Delete</th>
            </tr>
        </thead>
        <!-- Table body that gets populated by GetUser.php -->
        <tbody class="userTable"></tbody>
    </table>
</div>
<!-- Jquery Ajax to get user data and display in <tbody>-->
<script type="text/javascript">
    $(document).ready(function() {
        function getData() {
            $.ajax({
                url: 'getUser.php',
                type: 'GET',
            }).done(function(response) {
                $('.userTable').html(response);
            });
        }
        getData();
        var intervalTiming = setInterval(getData, 60000); // Update table every 60 seconds

        // Delete
        $('body').on('click', '.delete', function() {
            console.log('DELETE');
            // Delete id
            var deleteid = $(this).data('id');
            console.log('DELETE', deleteid);
            // AJAX Request
            $.ajax({
                url: 'delete.php',
                type: 'POST',
                data: {
                    id: deleteid
                }
            }).done(function(response) {
                getData();
            });
        });

        //Edit
        $('body').on('click', '.edit', function(e) {
            //Console
            var editid = $(this).data('id');
            console.log('EDITING', editid);
            //Email
            const emailFieldChange = $(e.target).closest('tr').find('.emailResult');
            const emailCurrValue = emailFieldChange.html();
            emailFieldChange.html(`<input value="${emailCurrValue}" />`);
            //Fname
            const fNameFieldChange = $(e.target).closest('tr').find('.fNameResult');
            const fNameCurrValue = fNameFieldChange.html();
            fNameFieldChange.html(`<input value="${fNameCurrValue}" />`);
            //Lname
            const lNameFieldChange = $(e.target).closest('tr').find('.lNameResult');
            const lNameCurrValue = lNameFieldChange.html();
            lNameFieldChange.html(`<input value="${lNameCurrValue}" />`);
            //Console check to ensure right details are being edited
            console.log(emailCurrValue, fNameCurrValue, lNameCurrValue)
            // Class change to be able to run save function
            if ($(".edit").data('id') == editid) {
                $(".edit").html('Save');
                $(".edit").addClass('save');
                $(".save").removeClass('bg-warning edit');
                $(".save").addClass('bg-success');
            };

        });

        //Save
        $('body').on('click', '.save', function(e) {
            // Save id
            var saveid = $(this).data('id');
            var eMail = $('.emailResult').find('input').val();
            var fName = $('.fNameResult').find('input').val();
            var lName = $('.lNameResult').find('input').val();
            console.log('SAVING', saveid);
            // AJAX Request
            $.ajax({
                url: 'edit.php',
                type: 'POST',
                data: {
                    id: saveid,
                    email: eMail,
                    fname: fName,
                    lname: lName
                }
            }).done(function(response) {
                //Paste new values back into table so you don't need to refresh
                //Email
                const newEmailValue = eMail;
                const emailField = $(e.target).closest('tr').find('.emailResult');
                const emailValue = emailField.html();
                emailField.html(newEmailValue);
                //Fname
                const newFnameValue = fName;
                const fNameField = $(e.target).closest('tr').find('.fNameResult');
                const FnameValue = fNameField.html();
                fNameField.html(newFnameValue);
                //Lname
                const newLnameValue = lName;
                const lNameField = $(e.target).closest('tr').find('.lNameResult');
                const LnameValue = lNameField.html();
                lNameField.html(newLnameValue);


                if ($(".save").data('id') == saveid) {
                    $(".save").html('Edit');
                    $(".save").addClass('edit');
                    $(".edit").removeClass('bg-success save');
                    $(".edit").addClass('bg-warning');
                };
            });
        });
    });

</script>
<?php
}
else {
  header("Location:../index.php");
  echo "Please enter admin credentials";
  die("access denied");
};
