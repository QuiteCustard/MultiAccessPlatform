<!-- Admin Log in-->
<!DOCTYPE html>
<html lang="en">
<?php include_once ("_include/head.php") ?>

<body class="tertiary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6 primary text">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 mb-4 textOuter">Welcome Back!</h1>
                                    </div>
                                    <form class="user" id="loginForm" method="post" action="admin/auth.php">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user primary" name="Email" id="inputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user primary" name="Password" id="inputPassword" placeholder="Password" required>
                                        </div>
                                        <?php
// Get errors
if (isset($_GET["e"])){
    include_once ("admin/logging.php");
}
?>
                                        <button class="btn btn-primary btn-user btn-block secondary secondaryBorder" action="submit" type="submit">Sign in</button>
                                        <script>
                                            grecaptcha.ready(function() {
                                                grecaptcha.execute('6Le7Tm4aAAAAAOnwdIrgEorh4MnL8giOGo2N-z8-', {
                                                    action: 'submit'
                                                }).then(function(token) {
                                                    var recaptchaResponse = document.getElementById('recaptchaResponse');
                                                    recaptchaResponse.value = token;
                                                });
                                            });

                                        </script>
                                        <input type="hidden" name="recaptcha_response" id="recaptchaResponse">
                                    </form>
                                    <div class="textOuter">
                                        <div class="text-center">
                                            <a class="small" href="forgotPassword.php">Forgot Password?</a>
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
    </div>
    <?php include_once ("_include/footer.php"); ?>
</body>

</html>
