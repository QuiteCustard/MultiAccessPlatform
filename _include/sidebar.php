<!-- Sidebar -->
<ul class="navbar-nav tertiary sidebar-dark sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-0">
            <i class="fas fa-dungeon"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Management system</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin/index.php">
            <i class="fas fa-chalkboard-teacher"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Addons
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Tools</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="body py-2 collapse-inner rounded secondaryBorder">
                <h6 class="collapse-header">Tools:</h6>
                <a class="collapse-item" id="user" data-toggle="user" href="#">View Users</a>
                <a class="collapse-item" href="#" data-toggle="course" id="course">View All Courses</a>
                <a class="collapse-item" href="#" id="enrolCourse">Enrol on Course</a>
<?php
if ($auth == "admin" || $auth == "owner") {
?>
                <a class="collapse-item" href="#" id="insert">Insert Users/Courses</a>
                <a class="collapse-item" href="#" id="userOnCourse">Users on courses</a>
                <?php
                }
                ?>
                <div class="collapse-divider"></div>
            </div>
        </div>
    </li>
    <script>
        $(document).ready(function() {
            const ajaxContent = $("#ajaxContent");
            $("#user, .user-button").click(function(str) {
                // If content is already filled then remove it
                if (str == "") {
                    ajaxContent.html = "";
                    return;
                } else {
                    $.ajax({ //create an ajax request to users.php
                        type: "GET",
                        url: "users.php",
                        dataType: "html", //expect html to be returned
                        success: function(response) {
                            ajaxContent.hide().fadeOut(1).html(response).fadeIn(3000);
                        }
                    });
                };
            })

            $("#course, .course-button").click(function(str) {
                // If content is already filled then remove it
                if (str == "") {
                    ajaxContent.html = "";
                    return;
                } else {
                    $.ajax({ //create an ajax request to courses.php
                        type: "GET",
                        url: "courses.php",
                        dataType: "html", //expect html to be returned
                        success: function(response) {
                           ajaxContent.hide().fadeOut(1).html(response).fadeIn(3000);
                        }
                    });
                };
            })

            $("#insert, .insert-button").click(function(str) {
                // If content is already filled then remove it
                if (str == "") {
                    ajaxContent.html = "";
                    return;
                } else {
                    $.ajax({ //create an ajax request to courses.php
                        type: "GET",
                        url: "insertUserAndCourse.php",
                        dataType: "html", //expect html to be returned
                        success: function(response) {
                           ajaxContent.hide().fadeOut(1).html(response).fadeIn(3000);
                        }
                    });
                };
            });

            $("#enrolCourse, .enrol-button").click(function(str) {
                // If content is already filled then remove it
                if (str == "") {
                    ajaxContent.html = "";
                    return;
                } else {
                    $.ajax({ //create an ajax request to courses.php
                        type: "GET",
                        url: "enrolCourse.php",
                        dataType: "html", //expect html to be returned
                        success: function(response) {
                            ajaxContent.hide().fadeOut(1).html(response).fadeIn(3000);
                        }
                    });
                };
            });

            $("#userOnCourse, .remove-button").click(function(str) {
                // If content is already filled then remove it
                if (str == "") {
                    ajaxContent.html = "";
                    return;
                } else {
                    $.ajax({ //create an ajax request to courses.php
                        type: "GET",
                        url: "userOnCourse.php",
                        dataType: "html", //expect html to be returned
                        success: function(response) {
                            ajaxContent.hide().fadeOut(1).html(response).fadeIn(3000);
                        }
                    });
                };
            });
        });

    </script>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- buttons to select theme -->
    <div class="container-fluid justify-content-centre theme">
        <button id="light" value="light"></button>
        <button id="dark" value="dark"></button>
        <button id="purple" value="purple"></button>
        <button id="forest" value="forest"></button>

    </div>
    <script>

        // Select theme depending on which button clicked
        const themeBtns = document.querySelectorAll('.theme > button')
        themeBtns.forEach((btn) => {
            btn.addEventListener('click', handleThemeUpdate)
        })
        function handleThemeUpdate(e) {
            document.documentElement.setAttribute('data-theme', e.target.value);
            localStorage.setItem('theme', e.target.value);
        }
    </script>


    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
