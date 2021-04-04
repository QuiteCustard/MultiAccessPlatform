<?php 
include_once("_logincheck.php");
if ($auth == "admin" || $auth == "user" || $auth == "owner") {
  // Table headers
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
                <?php
    if ($auth == "admin" || $auth == "owner") {
       // Check to ensure only admin accounts can access
  ?>

                <th scope='col' id='edit'>Edit</th>
                <th scope='col' id='delete'>Delete</th>
                <?php
    }
    ?>
            </tr>
        </thead>
        <tbody class="courseTable"></tbody>
    </table>
</div>
<!-- Jquery Ajax to get user data and display in <tbody>-->
<script type="text/javascript">
    $(document).ready(function() {
        function getData() {
            const getCourseData = "getCourseData";
            $.ajax({
                url: 'cases.php',
                type: 'GET',
                data: {
                    case: getCourseData
                }

            }).done(function(response) {
                $('.courseTable').html(response);
            });
        }
        getData();

        // Update table every 60 seconds
        var intervalTiming = setInterval(getData, 60000);

        // Course search
        function courseSearch() {
            // Update data after every key press
            $('#search').on('keyup', function() {
                const input = $("#search");
                const filter = input.val().toUpperCase();
                const table = $(".courseTable");
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
        courseSearch();
        // Delete
        $('body').off('click', '.delete').on('click', '.delete', function() {
            // Delete id
            var deleteid = $(this).data('id');
            const deleteCase = "deleteCourse";
            console.log('DELETE', deleteid);
            // Check to confirm correct record
            var c = confirm("Are you sure you want delete this course?");
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
                    getData();
                });

            } else {
                //Do nothing
                console.log("course", deleteid, "not deleted");
            }
        });
        // Edit
        $('body').off('click', '.edit').on('click', '.edit', function(e) {
            // Stop timer
            clearInterval(intervalTiming);
            // Set edit button to variable
            const editButton = $(e.target);
            //Console
            var editid = $(this).data('id').toString();
            // Set delete button to variable
            const deleteButton = $(`.delete[data-id=${editid}]`);
            console.log('EDITING', editid);
            // Title
            // Find correct table data column
            const titleFieldChange = editButton.closest('tr').find('.titleResult');
            // Set variable to value of td column
            const titleCurrValue = titleFieldChange.text();
            // Set result as input with data inside
            titleFieldChange.html(`<input class="form-control form-control-user primary" value="${titleCurrValue}" />`);
            // Date
            // Find correct table data column
            const dateFieldChange = editButton.closest('tr').find('.dateResult');
            // Set variable to value of td column
            const dateCurrValue = dateFieldChange.text();
            // Set result as input with data inside
            dateFieldChange.html(`<input type="text" id="datepicker" class="form-control form-control-user primary" value="${dateCurrValue}" />`);
            var picker = new Pikaday({
                field: $('#datepicker')[0]
            });
            // Duration
            // Find correct table data column
            const durationFieldChange = editButton.closest('tr').find('.durationResult');
            // Set variable to value of td column
            const durationCurrValue = durationFieldChange.text();
            // Set result as input with data inside
            durationFieldChange.html(`<input class="form-control form-control-user primary" value="${durationCurrValue}" />`);
            // Find correct table data column
            const descriptionFieldChange = editButton.closest('tr').find('.descriptionResult');
            // Set variable to value of td column
            const descriptionCurrValue = descriptionFieldChange.text();
            // Set result as input with data inside
            // Description
            descriptionFieldChange.html(`<input class="form-control form-control-user primary" value="${descriptionCurrValue}" />`);
            // Attendees
            // Find correct table data column
            const attendeesFieldChange = editButton.closest('tr').find('.attendeesResult');
            // Set variable to value of td column
            const attendeesCurrValue = attendeesFieldChange.text();
            // Set result as input with data inside
            attendeesFieldChange.html(`<input class="form-control form-control-user primary" value="${attendeesCurrValue}" />`);
            // Class change to be able to run save/cancel functions
            // Turn edit button into save button
            editButton.html('Save');
            editButton.addClass('save');
            editButton.removeClass('bg-warning edit');
            editButton.addClass('bg-success');
            /// Turn delete button into cancel button
            deleteButton.html('Cancel');
            deleteButton.addClass('cancel');
            deleteButton.removeClass('bg-danger delete');
            deleteButton.addClass('bg-primary');
        });

        // Save
        $('body').off('click', '.save').on('click', '.save', function(e) {
            // Set save button to variable
            const saveButton = $(e.target);
            var saveid = $(this).data('id');
            const saveCase = "saveCourse";
            // Set cancel button to variable
            const cancelButton = $(`.cancel[data-id=${saveid}]`);
            var title = $('.titleResult').find('input').val();
            var date = $('.dateResult').find('input').val();
            var duration = $('.durationResult').find('input').val();
            var description = $('.descriptionResult').find('input').val();
            var attendees = $('.attendeesResult').find('input').val();
            console.log('SAVING', saveid);
            // AJAX Request
            // Check to confirm correct record
            var c = confirm("Are you sure you want to save the inputted details for this course?");
            if (c == true) {
                $.ajax({
                    url: 'cases.php',
                    type: 'POST',
                    data: {
                        id: saveid,
                        title: title,
                        date: date,
                        duration: duration,
                        description: description,
                        attendees: attendees,
                        case: saveCase
                    }
                }).done(function(response) {
                    //Restart timer
                    intervalTiming = setInterval(getData(), 60000);
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
            } else {
                //Do nothing
                console.log("course", saveid, "not edited");
            }

        });

        //Cancel
        $('body').off('click', '.cancel').on('click', '.cancel', function(e) {
            // Set cancel button to variable
            const cancelButton = $(e.target);
            var saveid = $(this).data('id').toString();
            // Set save button to variable
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
<?php
}


else {
header("Location:../index.php");
echo "Please enter admin credentials";
die("access denied");
}
