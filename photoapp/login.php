<?php include('server.php') ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Photo App</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href="css/fontawesome.min.css" rel="stylesheet"></link>
        <link rel="stylesheet" type="text/css" href="css/util.css">
        <link rel="stylesheet" type="text/css" href="css/main.css">
    </head>
    <body>
        <div class="container-login100">
            <div class="wrap-login100 p-t-70 p-b-10">
                <form class="login100-form" method = "POST" action="login.php">
                    <span class="login100-form-title p-b-70">
                            Welcome, please Login!
                    </span>
										<?php if (isset($_GET['logout']) && count($errors) == 0) : ?>
				                <div class="login100-error">
				                    <span>You are now logged out</span>
				                </div>
				            <?php endif ?>
										<?php if (isset($_SESSION['msg']) && count($errors) == 0) : ?>
				                <div class="login100-error">
				                    <span><?php echo $_SESSION['msg'] ?></span>
				                </div>
				            <?php endif ?>

                    <?php include('errors.php'); ?>

                    <div class="wrap-input100 validate-input m-t-85 m-b-35">
                        <input class="input100" type="text" name="username">
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 validate-input m-b-50">
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button type = "submit" class="login100-form-btn" name="login_user">
                            Login
                        </button>
                    </div>

                    <ul class="login-more p-t-80">
                        <li>
                            <span class="txt1">
                                Not a member?
                            </span>
                            <a href="register.php" class="txt2">
                                Sign up!
                            </a>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <script src="js/jquery-3.4.1.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
    </body>
</html>
