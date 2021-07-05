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
	<div class="container">
    <div class="tab-pane m-t-60 col-lg-9 m-l-100">
        <span class="login100-form-title p-b-70">
                            Please complete all the fileds to create a new account
                    </span>
        <?php include('errors.php'); ?>
				<br>
        <form action = "register.php" method="POST">
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Name</label>
                <div class="col-lg-9">
                    <input class="form-control" type="text" name="name" placeholder="Name">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                <div class="col-lg-9">
                    <input class="form-control" type="email" name="email" placeholder="Email">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Username</label>
                <div class="col-lg-9">
                    <input class="form-control" type="text" name="username" placeholder="Username">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Password</label>
                <div class="col-lg-9">
                    <input class="form-control" type="password" name="password_1">
                </div>
            </div>
						<div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label">Confirm Password</label>
                <div class="col-lg-9">
                    <input class="form-control" type="password" name="password_2">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-3 col-form-label form-control-label"></label>
                <div class="col-lg-9">
                    <input type="reset" class="btn btn-secondary" value="Cancel">
                    <input type="submit" class="btn btn-primary" value="Create user" name="reg_user">
                </div>

            </div>
            <ul class="login-more p-t-10 m-l-190">
                <li>
                            <span class="txt1">
                              Have an account?
                            </span>
                    <a href="login.php" class="txt2">
                        Login!
                    </a>
                </li>
            </ul>
        </form>
    </div>
</div>
</body>
</html>
