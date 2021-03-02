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
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>

                                    <form class="user" id="loginForm" method="post" action="admin/auth.php">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="Email" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" name="Password" id="inputPassword" placeholder="Password" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <?php
                                            if(isset($_GET["e"])){
                                                 include_once("admin/logging.php");


                                                if($_GET["e"]=="1")
                                                {
                                                    echo "<h3> No username or password entered </h3>";
                                                }
                                                else if ($_GET["e"]=="2")
                                                {
                                                    echo "<h3> Wrong information </h3>";
                                                }
                                                else if ($_GET["e"]=="3")
                                                {
                                                    echo "<h3>Trying to enter page you don't have permission for / Insecure </h3>";
                                                }
                                                else if ($_GET["e"]=="4")
                                                {
                                                    echo "Logged out";
                                                }
                                            }
                                            ?>
                                        <button class="btn btn-primary btn-user btn-block" type="submit">Sign in</button>
                                        <script>
                                            grecaptcha.ready(function() {
                                                grecaptcha.execute('6Le7Tm4aAAAAAOnwdIrgEorh4MnL8giOGo2N-z8-', {
                                                    action: 'login'
                                                }).then(function(token) {
                                                    var recaptchaResponse = document.getElementById('recaptchaResponse');
                                                    recaptchaResponse.value = token;
                                                });
                                            });
                                        </script>
                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
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
</html>