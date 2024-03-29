<?php 
require_once("_logincheck.php");
// Check to ensure only logged in accounts can access this page
if ($auth == "admin" || $auth == "user" || $auth == "owner" ){
  ?>
<div class='row'>
    <div class='col-md-10'>
        <h3>Users</h3>
    </div>
    <div class='col-md-2'>
        <input type="text" id="search" class="form-control primary inputs" placeholder="Search.." />
        <p class="text-center">You can search by all rows</p>
    </div>
</div>
<!-- Table for users -->
<div class='table-responsive'>
    <table class='table table-hover' id="tTable">
        <thead>
            <tr>
                <th scope='col'>UID</th>
                <th scope='col'>Email</th>
                <th scope='col'>Fname</th>
                <th scope='col'>Lname</th>
                <th scope='col'>Job title</th>
                <th scope='col'>Access Level</th>
                <th scope='col'>Current Course</th>
                <th scope='col'>Time</th>
                <th scope='col' id='editHeader'>Edit</th>
                <?php
    // Prevent user from seeing delete header of table
   if ($auth == "admin" || $auth == "owner"){
?>
                <th scope='col' id='deleteHeader'>Delete</th>
                <?php
   }
     ?>
            </tr>
        </thead>
        <!-- Table body that gets populated by getUser.php -->
        <tbody class="userTable"></tbody>
    </table>
</div>
<div class="response"></div>
<!-- Jquery Ajax to get user data and display in <tbody>-->
<script type="text/javascript">
    $(document).ready(function() {
        const responseDiv = $(".response");

        function getData() {
            const getUserData = "getUserData";
            $.ajax({
                url: 'cases.php',
                type: 'GET',
                data: {
                    case: getUserData
                }
            }).done(function(response) {
                $('.userTable').html(response);
            });
        }
        getData();
        // Update table every 60 seconds
        var intervalTiming = setInterval(getData(), 60000);
        // User search
        function userSearch() {
            // Update data after every key press
            $('#search').on('keyup', function() {
                const input = $("#search");
                const filter = input.val().toUpperCase();
                const table = $(".userTable");
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
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            });
        };
        userSearch();
        // Delete function
        $('body').off('click', '.delete').on('click', '.delete', function() {
            var deleteid = $(this).data('id');
            // Check to confirm correct record
            const deleteCase = "deleteUser";
            var c = confirm("Are you sure you want delete this user?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        id: deleteid,
                        case: deleteCase
                    }
                }).done(function(response) {
                    // Paste response from php into div
                    responseDiv.html(response);
                    // Refresh data
                    getData();
                });
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
            // Email
            // Find correct table data column
            const emailFieldChange = editButton.closest('tr').find('.emailResult');
            // Set variable to value of td column
            const emailCurValue = emailFieldChange.text();
            // Set result as input with data inside
            emailFieldChange.html(`<input class="form-control form-control-user primary" value="${emailCurValue}" />`);
            // Fname
            // Find correct table data column
            const fNameFieldChange = editButton.closest('tr').find('.fNameResult');
            // Set variable to value of td column
            const fNameCurValue = fNameFieldChange.text();
            // Set result as input with data inside
            fNameFieldChange.html(`<input class="form-control form-control-user primary" value="${fNameCurValue}" />`);
            // Lname
            // Find correct table data column
            const lNameFieldChange = editButton.closest('tr').find('.lNameResult');
            // Set variable to value of td column
            const lNameCurrValue = lNameFieldChange.text();
            // Set result as input with data inside
            lNameFieldChange.html(`<input class="form-control form-control-user primary" value="${lNameCurrValue}" />`);
            // Job
            // Find correct table data column
            const jobFieldChange = editButton.closest('tr').find('.jobResult');
            // Set variable to value of td column
            const jobCurrValue = jobFieldChange.text();
            // Set result as input with data inside
            jobFieldChange.html(`<input class="form-control form-control-user primary" value="${jobCurrValue}" />`);
            // Access level -- This can only be edited by the owner account
            // Find correct table data column
            const accessFieldChange = editButton.closest('tr').find('.accessResult');
            // Set variable to value of td column
            const accessCurrValue = accessFieldChange.text();
            const accessSelector = "accessSelector";
            $.ajax({
                url: 'cases.php',
                type: 'POST',
                data: {
                    case: accessSelector,
                    accessVal: accessCurrValue
                }
            }).done(function(response) {
                // Set result as input with data inside
                accessFieldChange.html(response);
            });
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
        // Append "selected" to the correct option if it is selected
        $(document).on("change", "select", function() {
            $("option[value=" + this.value + "]", this).attr("selected", true).siblings().removeAttr("selected")
        });
        // Save
        $('body').off('click', '.save').on('click', '.save', function(e) {
            // Set save button to variable
            const saveButton = $(e.target);
            var saveid = $(this).data('id').toString();
            const saveCase = "saveUser";
            // Set cancel button to variable
            const cancelButton = $(`.cancel[data-id=${saveid}]`);
            var email = $('.emailResult').find('input').val();
            var fname = $('.fNameResult').find('input').val();
            var lname = $('.lNameResult').find('input').val();
            var job = $('.jobResult').find('input').val();
            var access = $('.accessResult').find('select').val();
            // Check to confirm correct record
            var c = confirm("Are you sure you want to save the inputted details for this user?");
            if (c == true) {
                // AJAX Request
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        id: saveid,
                        email: email,
                        fname: fname,
                        lname: lname,
                        job: job,
                        access: access,
                        case: saveCase
                    }
                }).done(function(response) {
                    // Paste response from php into div
                    responseDiv.html(response);
                    // Restart timer
                    intervalTiming = setInterval(getData(), 60000);
                    // Paste new values back into table so you don't need to refresh
                    // Email
                    const emailField = saveButton.closest('tr').find('.emailResult');
                    emailField.html(email);
                    // Fname
                    const fNameField = saveButton.closest('tr').find('.fNameResult');
                    fNameField.html(fname);
                    // Lname
                    const lNameField = saveButton.closest('tr').find('.lNameResult');
                    lNameField.html(lname);
                    // Job
                    const jobField = saveButton.closest('tr').find('.jobResult');
                    jobField.html(job);
                    // Access
                    const accessField = saveButton.closest('tr').find('.accessResult');
                    accessField.html(access);
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
            }
        });
        //Cancel
        $('body').off('click', '.cancel').on('click', '.cancel', function(e) {
            // Set cancel button to variable
            const cancelButton = $(e.target);
            // Set save button to variable
            var saveid = $(this).data('id').toString();
            const saveButton = $(`.save[data-id=${saveid}]`);
            // Paste old values back into table so you don't need to refresh
            getData();
            // Turn cancel button into delete button
            cancelButton.html('Delete');
            cancelButton.addClass('delete');
            cancelButton.removeClass('bg-primary cancel');
            cancelButton.addClass('bg-danger');
            // Turn save button into edit button
            saveButton.html('Edit');
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
  echo "Please enter credentials to access this page";
  die("access denied");
};
