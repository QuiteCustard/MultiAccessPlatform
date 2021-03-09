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
        var intervalTiming = setInterval(getData(), 2000); // Update table every 60 seconds
        function getData() {
            $.ajax({
                url: 'getUser.php',
                type: 'GET',
            }).done(function(response) {
                $('.userTable').html(response);
            });
        }
        getData();


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
                    id: deleteid,
                }
            }).done(function(response) {
                getData();
            });
        });

        //Edit
        $('body').on('click', '.edit', function(e) {
            clearInterval(intervalTiming); // Stop
            const editButton = $(e.target);
            //Console
            var editid = $(this).data('id').toString();
            const deleteButton = $(`.delete[data-id=${editid}]`);
            console.log('EDITING', editid);
            //Email
            const emailFieldChange = editButton.closest('tr').find('.emailResult');
            const emailCurrValue = emailFieldChange.html();
            emailFieldChange.html(`<input value="${emailCurrValue}" />`);
            //Fname
            const fNameFieldChange = editButton.closest('tr').find('.fNameResult');
            const fNameCurrValue = fNameFieldChange.html();
            fNameFieldChange.html(`<input value="${fNameCurrValue}" />`);
            //Lname
            const lNameFieldChange = editButton.closest('tr').find('.lNameResult');
            const lNameCurrValue = lNameFieldChange.html();
            lNameFieldChange.html(`<input value="${lNameCurrValue}" />`);
            // Class change to be able to run save/cancel functions
            // Turn edit button into save button
            editButton.html('Save');
            editButton.addClass('save');
            editButton.removeClass('bg-warning edit');
            editButton.addClass('bg-success');
            //Turn delete button into cancel button
            deleteButton.html('Cancel');
            deleteButton.addClass('cancel');
            deleteButton.removeClass('bg-danger delete');
            deleteButton.addClass('bg-primary');
        });

        // Save
        $('body').on('click', '.save', function(e) {
            const saveButton = $(e.target);
            // Save id
            var saveid = $(this).data('id').toString();
            const cancelButton = $(`.cancel[data-id=${saveid}]`);
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

                // Paste new values back into table so you don't need to refresh
                // Email
                const newEmailValue = eMail;
                const emailField = saveButton.closest('tr').find('.emailResult');
                const emailValue = emailField.html();
                emailField.html();
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
        });

        //Cancel
        $('body').on('click', '.cancel', function(e) {
            const cancelButton = $(e.target);
            var saveid = $(this).data('id').toString();
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
