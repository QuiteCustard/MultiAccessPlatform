<?php 
// Main admin page
// Check to ensure only admin or user accounts can access this page
    include_once("_logincheck.php");
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
                    <div id="ajaxContent"></div>
                    <!-- Page Heading -->
                </div>

                <!-- /.container-fluid -->
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer body">
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
