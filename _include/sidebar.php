<!-- Sidebar -->
<ul class="navbar-nav tertiary sidebar-dark sidebar accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Management system</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="/admin/index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
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
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Tools:</h6>
                <a class="collapse-item" href="#" onclick="showUser()">Users</a>
                <a class="collapse-item" href="#" onclick="showCourse()">Courses</a>
                <a class="collapse-item" href="/forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="/404.html">404 Page</a>
                <a class="collapse-item" href="/blank.php">Blank Page</a>
            </div>
        </div>
    </li>


    <!-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
            <i class="fas fa-fw fa-folder"></i>
            <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Login Screens:</h6>
                <a class="collapse-item" href="/index.php">Login</a>
                <a class="collapse-item" href="/register.html">Register</a>
                <a class="collapse-item" href="/forgot-password.html">Forgot Password</a>
                <div class="collapse-divider"></div>
                <h6 class="collapse-header">Other Pages:</h6>
                <a class="collapse-item" href="/404.html">404 Page</a>
                <a class="collapse-item" href="/blank.php">Blank Page</a>
            </div>
        </div>
    </li>-->


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- buttons to select theme -->
    <div class="theme">
        <button id="light" value="light"></button>
        <button id="dark" value="dark"></button>
        <button id="purple" value="purple"></button>
        <button id="forest" value="forest"></button>

    </div>


    <!--<script>
        Tooltips
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
    </script>-->
    <!-- Select theme depending on which button clicked -->
    <script>
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

    <!-- Sidebar Message -->
    <div class="sidebar-card">
        <img class="sidebar-card-illustration mb-2" src="/img/undraw_rocket.svg" alt="">
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
