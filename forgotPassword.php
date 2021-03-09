<!-- Admin Log in-->

<!DOCTYPE html>
<html lang="en">

<?php include_once("_include/head.php")?>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user emailInput" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                        </div>

                                        <a href="#" class="btn btn-primary btn-user btn-block reset">
                                            Reset Password
                                        </a>
                                    </form>

                                    <script type="text/javascript">
                                        $(document).ready(function() {
                                            // reset
                                            $('body').on('click', '.reset', function(e) {
                                                // email reset
                                                var resetEmail = $('.emailInput').val();
                                                console.log('RESET', resetEmail);
                                                // AJAX Request
                                                $.ajax({
                                                    url: 'admin/reset.php',
                                                    type: 'POST',
                                                    data: {
                                                        email: resetEmail,
                                                    }
                                                }).done(function(response) {
                                                    alert("Please check your emails");
                                                });
                                            });
                                        });

                                    </script>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="index.php">Already have an account? Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <?php include_once("_include/footer.php")?>

</body>
