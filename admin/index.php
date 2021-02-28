<?php 
    include_once("_logincheck.php");
    if ($auth == "admin" || $auth == "user")
        {
            include_once("../_include/head.php");
            echo '
                <!DOCTYPE html>
                <html lang="en">
                <body id="page-top">
                    <!-- Page Wrapper -->
                    <div id="wrapper">';

            include_once("../_include/sidebar.php");
            include_once("../_include/navbar.php");
            echo '
                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column ">
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
                    <footer class="sticky-footer bg-white">
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
                </body>

                </html>';
        include_once("../_include/footer.php");
        }
        else
        {
        header("Location:../index.php");
        die("access denied");
        }

