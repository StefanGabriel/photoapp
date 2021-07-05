<?php include('server.php') ?>
<?php
	if (!isset($_SESSION['username'])) {
		$_SESSION['msg'] = "You must log in first";
		header('location: login.php');
	}

	if (isset($_GET['logout'])) {
		session_destroy();
		unset($_SESSION['username']);
		header("location: login.php?logout='1'");
	}
?>

<!DOCTYPE html>
<html>
<head>
		<title>My account</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/fontawesome.min.css" rel="stylesheet"></link>
		<link rel="stylesheet" type="text/css" href="css/util.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<?php include('navbar.php') ?>
<?php
$name = "";
if(isset($_SESSION['username']))
{
    $SessionUser = $_SESSION['username'];
    $query = "SELECT name, email FROM users WHERE username='$SessionUser'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $row = mysqli_fetch_assoc($results);
      $name = $row["name"];
      $email = $row["email"];
    }
    else {
        echo "0 results";
    }
}
 ?>
<body>
  <div class="container">
      <div class="tab-pane m-t-60">
        <?php include('errors.php'); ?>
        <?php if (isset($_SESSION['msg']) && count($errors) == 0) : ?>
            <div class="login100-error">
                <span><?php echo $_SESSION['msg'] ?></span>
            </div>
        <?php endif ?>
        <br>
          <form action = "" method="POST">
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Name</label>
                  <div class="col-lg-9">
                      <input class="form-control" type="text" value="<?php echo $name ?>" name="name">
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Email</label>
                  <div class="col-lg-9">
                      <input class="form-control" type="email" value="<?php echo $email ?>" name="email">
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Username</label>
                  <div class="col-lg-9">
                      <input class="form-control" type="text" readonly="readonly" name="username" value="<?php echo $_SESSION['username'] ?>">
                  </div>
              </div>

              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label"></label>
                  <div class="col-lg-9">
                      <input type="reset" class="btn btn-secondary" value="Cancel">
                      <input type="submit" class="btn btn-primary" name="update_details" value="Update">
                  </div>
              </div>
          </form>
      </div>
      <div class="tab-pane m-t-60">
          <form action = "" method="POST">
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Old Password</label>
                  <div class="col-lg-9">
                      <input class="form-control" required type="password" name="oldpass">
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">New Password</label>
                  <div class="col-lg-9">
                      <input class="form-control" required type="password" name="newpass">
                  </div>
              </div>
              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                  <div class="col-lg-9">
                      <input class="form-control" required type="password" name="newpassconfirm">
                  </div>
              </div>

              <div class="form-group row">
                  <label class="col-lg-3 col-form-label form-control-label"></label>
                  <div class="col-lg-9">
                      <input type="reset" class="btn btn-secondary" value="Cancel">
                      <input type="submit" class="btn btn-primary" name="password_change" value="Change Password">
                  </div>
              </div>
          </form>
      </div>
  </div>
</body>
</html>
