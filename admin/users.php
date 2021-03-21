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
                <th scope='col' id='editHeader'>Edit</th>
                <th scope='col' id='deleteHeader'>Delete</th>
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
        // Update table every 60 seconds
        var intervalTiming = setInterval(getData(), 60000);
        // Delete function
        $('body').off('click', '.delete').on('click', '.delete', function() {
            var deleteid = $(this).data('id');
            console.log('DELETE', deleteid);
            // Check to confirm correct record
            var c = confirm("Are you sure you want delete this user?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'deleteUser.php',
                    type: 'POST',
                    data: {
                        id: deleteid,
                    }
                }).done(function(response) {
                    getData();
                });
            } else {
                //Do nothing
                console.log("user", deleteid, "not deleted");
            }
        });

        //Edit
        $('body').off('click', '.edit').on('click', '.edit', function(e) {
            // Stop timer to allow for editing
            clearInterval(intervalTiming);
            // Set edit button to variable
            const editButton = $(e.target);
            var editid = $(this).data('id').toString();
            // Set delete button to variable
            const deleteButton = $(`.delete[data-id=${editid}]`);
            console.log('EDITING', editid);
            // Email
            // Find correct table data column
            const emailFieldChange = editButton.closest('tr').find('.emailResult');
            // Set variable to value of td column
            const emailFieldVal = emailFieldChange.html();
            // Set variable to value to fill the input
            const emailCurrValue = emailFieldChange.html();
            // Set result as input with data inside
            emailFieldChange.html(`<input class="form-control form-control-user primary" value="${emailFieldVal}" />`);
            // Fname
            // Find correct table data column
            const fNameFieldChange = editButton.closest('tr').find('.fNameResult');
            // Set variable to value of td column
            const fNameFieldValue = fNameFieldChange.html();
            // Set variable to value to fill the input
            const fNameCurrValue = fnameFieldChange.html();
            // Set result as input with data inside
            fNameFieldChange.html(`<input class="form-control form-control-user primary" value="${fNameFieldValue}" />`);
            // Lname
            // Find correct table data column
            const lNameFieldChange = editButton.closest('tr').find('.lNameResult');
            // Set variable to value of td column
            const lNameCurrValue = lNameFieldChange.html();
            // Set variable to value to fill the input
            const lNameFieldValue = lNameFieldChange.html();
            // Set result as input with data inside
            lNameFieldChange.html(`<input class="form-control form-control-user primary" value="${lNameFieldValue}" />`);
            // Class change to be able to run save & cancel functions
            // Turn edit button into save button
            editButton.html('Save');
            editButton.addClass('save');
            editButton.removeClass('bg-warning edit');
            editButton.addClass('bg-success');
            // Turn delete button into cancel button
            deleteButton.html('Cancel');
            deleteButton.addClass('cancel');
            deleteButton.removeClass('bg-danger delete');
            deleteButton.addClass('bg-primary');
        });

        // Save
        $('body').off('click', '.save').on('click', '.save', function(e) {
            // Set save button to variable
            const saveButton = $(e.target);
            var saveid = $(this).data('id').toString();
            // Set cancel button to variable
            const cancelButton = $(`.cancel[data-id=${saveid}]`);
            var eMail = $('.emailResult').find('input').val();
            var fName = $('.fNameResult').find('input').val();
            var lName = $('.lNameResult').find('input').val();
            // Check to confirm correct record
            var c = confirm("Are you sure you want to save the inputted details for this user?");
            console.log('SAVING', saveid);
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'editUser.php',
                    type: 'POST',
                    data: {
                        id: saveid,
                        email: eMail,
                        fname: fName,
                        lname: lName
                    }
                }).done(function(response) {
                    // Restart timer
                    intervalTiming = setInterval(getData(), 60000);
                    // Paste new values back into table so you don't need to refresh
                    // Email
                    const newEmailValue = eMail;
                    const emailField = saveButton.closest('tr').find('.emailResult');
                    const emailValue = emailField.html();
                    emailField.html(newEmailValue);
                    // Fname
                    const newFnameValue = fName;
                    const fNameField = saveButton.closest('tr').find('.fNameResult');
                    const FnameValue = fNameField.html();
                    fNameField.html(newFnameValue);
                    // Lname
                    const newLnameValue = lName;
                    const lNameField = saveButton.closest('tr').find('.lNameResult');
                    const LnameValue = lNameField.html();
                    lNameField.html(newLnameValue);
                    // Turn save button into edit button
                    saveButton.html('Edit');
                    saveButton.addClass('edit');
                    saveButton.removeClass('bg-success save');
                    saveButton.addClass('bg-warning');
                    // Turn cancel button into delete button
                    cancelButton.html('Delete');
                    cancelButton.addClass('delete');
                    cancelButton.removeClass('bg-primary cancel');
                    cancelButton.addClass('bg-danger');
                });
            } else {
                //Do nothing
                console.log("user", saveid, "not edited");
            }

        });
        //Cancel
        $('body').off('click', '.cancel').on('click', '.cancel', function(e) {
            // Set cancel button to variable
            const cancelButton = $(e.target);
            var saveid = $(this).data('id').toString();
            // Set save button to variable
            const saveButton = $(`.save[data-id=${saveid}]`);
            var eMail = $('.emailResult').find('input').val();
            var fName = $('.fNameResult').find('input').val();
            var lName = $('.lNameResult').find('input').val();
            // Paste old values back into table so you don't need to refresh
            // Email
            const newEmailValue = eMail;
            const emailField = cancelButton.closest('tr').find('.emailResult');
            const emailValue = emailField.html();
            emailField.html(newEmailValue);
            // Fname
            const newFnameValue = fName;
            const fNameField = cancelButton.closest('tr').find('.fNameResult');
            const FnameValue = fNameField.html();
            fNameField.html(newFnameValue);
            // Lname
            const newLnameValue = lName;
            const lNameField = cancelButton.closest('tr').find('.lNameResult');
            const LnameValue = lNameField.html();
            lNameField.html(newLnameValue);
            // Turn cancel button into delete button
            cancelButton.html('Delete');
            cancelButton.addClass('delete');
            cancelButton.removeClass('bg-primary cancel');
            cancelButton.addClass('bg-danger');
            cancelButton.html('Edit');
            // Turn save button into edit button
            saveButton.addClass('edit');
            saveButton.removeClass('bg-success save');
            saveButton.addClass('bg-warning');
        });
    });

</script>
<br>

<?php
}

else {
  header("Location:../index.php");
  echo "Please enter admin credentials";
  die("access denied");
};
