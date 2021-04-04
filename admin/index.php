<?php 
// Main page
// Check to ensure only admin or user accounts can access this page
    require_once("_logincheck.php");
    if ($auth == "owner" || $auth == "admin" || $auth == "user")
        {
            include_once("../_include/head.php");
?>

<body id="page-top" class="body">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <?php
            include_once("../_include/sidebar.php");
            include_once("../_include/navbar.php");
?>
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div id="ajaxContent">
                        <div class="container">
                            <h1 class="text-center">What would you like to do?</h1>
                            <div class="row d-flex justify-content-center">
                                <?php
        if ($auth == "owner" || $auth == "admin"){
?>
                                <div class="col-sm">
                                    <div class="card body" style="width: 18rem;">
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Edit users</h5>
                                            <p class="card-text">Edit user records here!</p>
                                            <a href="#" class="btn btn-success align-center user-button">Go!</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card body" style="width: 18rem;">
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Edit Courses</h5>
                                            <p class="card-text">Edit course records here!</p>
                                            <a href="#" class="btn btn-success align-center course-button">Go!</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card body" style="width: 18rem;">
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">View and Remove users from courses</h5>
                                            <p class="card-text">View records here!</p>
                                            <a href="#" class="btn btn-success align-center remove-button">Go!</a>
                                        </div>
                                    </div>
                                </div>
<?php
        }else if($auth == "user")
        {
?>
                                <div class="col-sm">
                                    <div class="card body" style="width: 18rem;">
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">View your details</h5>
                                            <p class="card-text">View details here!</p>
                                            <a href="#" class="btn btn-success align-center user-button">Go!</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card body" style="width: 18rem;">
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">View Courses</h5>
                                            <p class="card-text">View all courses here!</p>
                                            <a href="#" class="btn btn-success align-center course-button">Go!</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm">
                                    <div class="card body" style="width: 18rem;">
                                        <img class="img-profile rounded-circle" src="/img/undraw_profile.svg">
                                        <div class="card-body text-center">
                                            <h5 class="card-title">Enrol on courses</h5>
                                            <p class="card-text">Enrol on courses here!</p>
                                            <a href="#" class="btn btn-success align-center enrol-button">Go!</a>
                                        </div>
                                    </div>
                                </div>
<?php
        }
?>
                            </div>
                        </div>
                    </div>
                    <!-- Page Heading -->
                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2020</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <?php
        include_once("../_include/footer.php");
        ?>

</body>
<?php
        }
        else
        {
        header("Location:../index.php");
        die("access denied");
        }
