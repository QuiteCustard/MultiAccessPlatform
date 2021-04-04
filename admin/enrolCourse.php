 <?php
    include_once("_logincheck.php");
    if ($auth == "admin" || $auth == "owner" || $auth == "user") {
?>
 <div class='row'>
     <div class='col-md-10'>
         <h3>Courses</h3>
     </div>
     <div class='col-md-2'>
         <input type="text" id="search" class="form-control primary inputs" placeholder="Search.." />
         <p class="text-center">You can search by both CID and Title of Course</p>
     </div>
 </div>
 <div class='table-responsive'>
     <table class='table table-hover'>
         <thead>
             <tr>
                 <th scope='col'>CID</th>
                 <th scope='col'>Title</th>
                 <th scope='col'>Max people allowed on course</th>
                 <th scope='col' id='enrol'>Enrol</th>
             </tr>
         </thead>
         <tbody class="courseEnrolTable"></tbody>
     </table>
 </div>
 <script type="text/javascript">
     function getEnrolCourseData() {
         const getEnrolCourse = "getEnrolCourse";
         $.ajax({
             url: 'cases.php',
             type: 'GET',
             data: {
                 case: getEnrolCourse
             }

         }).done(function(response) {
             $('.courseEnrolTable').html(response);
         });
     }
     getEnrolCourseData();
     // User search
     function courseSearch() {
         // Update data after every key press
         $('#search').on('keyup', function() {
             const input = $("#search");
             const filter = input.val().toUpperCase();
             const table = $(".courseEnrolTable");
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
     //Enrol
     $('body').off('click', '.enrol').on('click', '.enrol', function(e) {
         const enrolButton = $(e.target);
         const enrolOnCourse = "enrolOnCourse";
         var enrolid = $(this).data('id');
         // Log course being created
         console.log('ENROLING on course');
         var c = confirm("Are you sure you want to enrol on this course?");
         if (c == true) {
             // AJAX Request
             $.ajax({
                 url: 'cases.php',
                 type: 'POST',
                 data: {
                     id: enrolid,
                     case: enrolOnCourse
                 }
             }).done(function(response) {
                 console.log(response);
             });
         }
     });

 </script>
 <?php
    }else{
    header("Location:../index.php");
    echo "Please enter admin credentials";
    die("access denied");
}
