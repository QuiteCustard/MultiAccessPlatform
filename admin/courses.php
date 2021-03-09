<?php 
include_once("_logincheck.php");
// Check to ensure only admin accounts can access
if ($auth == "admin") {
  // Table headers
  ?>
<div class='table-responsive'>
    <table class='table table-hover'>
        <thead>
            <tr>
                <th scope='col'>CID</th>
                <th scope='col'>Title</th>
                <th scope='col'>Date</th>
                <th scope='col'>Duration</th>
                <th scope='col'>Description</th>
                <th scope='col'>Max Attendees</th>
                <th scope='col'>Time</th>
                <th scope='col' id='edit'>Edit</th>
                <th scope='col' id='delete'>Delete</th>
            </tr>
        </thead>
        <tbody class="courseTable"></tbody>
    </table>
</div>
<!-- Jquery Ajax to get user data and display in <tbody>-->
<script type="text/javascript">
    $(document).ready(function() {
        function getData() {
            $.ajax({
                url: 'getCourse.php',
                type: 'GET',
            }).done(function(response) {
                $('.courseTable').html(response);
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
                url: 'deleteCourse.php',
                type: 'POST',
                data: {
                    id: deleteid,
                }
            }).done(function(response) {
                getData();
            });
        });

        // Edit
        $('body').on('click', '.edit', function(e) {
            clearInterval(intervalTiming);
            const editButton = $(e.target);
            //Console
            var editid = $(this).data('id').toString();
            const deleteButton = $(`.delete[data-id=${editid}]`);
            console.log('EDITING', editid);
            // Title
            const titleFieldChange = editButton.closest('tr').find('.titleResult');
            const titleCurrValue = titleFieldChange.html();
            titleFieldChange.html(`<input value="${titleCurrValue}" />`);
            // Date
            const dateFieldChange = editButton.closest('tr').find('.dateResult');
            const dateCurrValue = dateFieldChange.html();
            dateFieldChange.html(`<input value="${dateCurrValue}" />`);
            // Duration
            const durationFieldChange = editButton.closest('tr').find('.durationResult');
            const durationCurrValue = durationFieldChange.html();
            durationFieldChange.html(`<input value="${durationCurrValue}" />`);
            // Description
            const descriptionFieldChange = editButton.closest('tr').find('.descriptionResult');
            const descriptionCurrValue = descriptionFieldChange.html();
            descriptionFieldChange.html(`<input value="${descriptionCurrValue}" />`);
            // Attendees
            const attendeesFieldChange = editButton.closest('tr').find('.attendeesResult');
            const attendeesCurrValue = attendeesFieldChange.html();
            attendeesFieldChange.html(`<input value="${attendeesCurrValue}" />`);
            // Class change to be able to run save/cancel functions
            // Turn edit button into save button
            editButton.html('Save');
            editButton.addClass('save');
            editButton.removeClass('bg-warning edit');
            editButton.addClass('bg-success');
            ///Turn delete button into cancel button
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
            var title = $('.titleResult').find('input').val();
            var date = $('.dateResult').find('input').val();
            var duration = $('.durationResult').find('input').val();
            var description = $('.descriptionResult').find('input').val();
            var attendees = $('.attendeesResult').find('input').val();
            console.log('SAVING', saveid);
            // AJAX Request
            $.ajax({
                url: 'editCourse.php',
                type: 'POST',
                data: {
                    id: saveid,
                    title: title,
                    date: date,
                    duration: duration,
                    description: description,
                    attendees: attendees
                }
            }).done(function(response) {
                intervalTiming = setInterval(getData(), 60000); //Restart timer
                // Paste new values back into table so you don't need to refresh
                // Title
                const newTitleValue = title;
                const titleField = saveButton.closest('tr').find('.titleResult');
                const titleValue = titleField.html();
                titleField.html(newTitleValue);
                // Date
                const newDateValue = date;
                const dateField = saveButton.closest('tr').find('.dateResult');
                const dateValue = dateField.html();
                dateField.html(newDateValue);
                // Duration
                const newDurationValue = duration;
                const durationField = saveButton.closest('tr').find('.durationResult');
                const durationValue = durationField.html();
                durationField.html(newDurationValue);
                // Description
                const newDescriptionValue = description;
                const descriptionField = saveButton.closest('tr').find('.descriptionResult');
                const descriptionValue = descriptionField.html();
                descriptionField.html(newDescriptionValue);
                // Attendees
                const newAttendeesValue = attendees;
                const attendeesField = saveButton.closest('tr').find('.attendeesResult');
                const attendeesValue = attendeesField.html();
                attendeesField.html(newAttendeesValue);
                // Turn save button int edit button
                saveButton.html('Edit');
                saveButton.addClass('edit');
                saveButton.removeClass('bg-success save');
                saveButton.addClass('bg-warning');
                // Turn cancel button into delete Button
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
            var title = $('.titleResult').find('input').val();
            var date = $('.dateResult').find('input').val();
            var duration = $('.durationResult').find('input').val();
            var description = $('.descriptionResult').find('input').val();
            var attendees = $('.attendeesResult').find('input').val();
            // Paste old values back into table so you don't need to refresh
            // Title
            const newTitleValue = title;
            const titleField = cancelButton.closest('tr').find('.titleResult');
            const titleValue = titleField.html();
            titleField.html(newTitleValue);
            // Date
            const newDateValue = date;
            const dateField = cancelButton.closest('tr').find('.dateResult');
            const dateValue = dateField.html();
            dateField.html(newDateValue);
            // Duration
            const newDurationValue = duration;
            const durationField = cancelButton.closest('tr').find('.durationResult');
            const durationValue = durationField.html();
            durationField.html(newDurationValue);
            // Description
            const newDescriptionValue = description;
            const descriptionField = cancelButton.closest('tr').find('.descriptionResult');
            const descriptionValue = descriptionField.html();
            descriptionField.html(newDescriptionValue);
            // Attendees
            const newAttendeesValue = attendees;
            const attendeesField = cancelButton.closest('tr').find('.attendeesResult');
            const attendeesValue = attendeesField.html();
            attendeesField.html(newAttendeesValue);
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
<?php
}
    // If not admin then display
    elseif($auth == "user")
{
        ?>
<h1>Currently displays user table as have not sorted user courses</h1>
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
                <th scope='col' id='delete'>Delete</th>
            </tr>
        </thead>
        <tbody class="userTable"></tbody>
    </table>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        function getData() {
            console.log('running data...');
            $.ajax({
                url: 'getUser.php',
                type: 'GET',
            }).done(function(response) {
                console.log('response', response);
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
                    id: deleteid
                }
            }).done(function(response) {
                console.log(response);
                getData();
            });
        });

        setInterval(getData, 1000);
    });

</script>

<?php
        }
else {
header("Location:../index.php");
echo "Please enter admin credentials";
die("access denied");
};
