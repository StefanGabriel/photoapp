<?php
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array();
	$_SESSION['success'] = "";
	$_SESSION['likess'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'photoapp');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$name = mysqli_real_escape_string($db, $_POST['name']);
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($name)) { array_push($errors, "The name is required"); }
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO users (name, username, email, password)
					  VALUES('$name', '$username', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}
	}

	// ...

	// LOGIN USER
	if (isset($_POST['login_user'])) {
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$password = mysqli_real_escape_string($db, $_POST['password']);

		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			$password = md5($password);
			$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
			$results = mysqli_query($db, $query);

			if (mysqli_num_rows($results) == 1) {
				$_SESSION['username'] = $username;
				$_SESSION['success'] = "You are now logged in";
				header('location: index.php');
			} else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	if(isset($_POST['update_details'])){
		$name = $_POST['name'];
		$email = $_POST['email'];
		$user = $_POST['username'];

		if (empty($name) || strlen($name) < 5) {
			array_push($errors, "Name is invalid");
		}

		if (empty($email)) {
			array_push($errors, "Invalid email");
		}

		if (count($errors) == 0) {
				$update_details = $db->query("UPDATE users SET name = '$name', email = '$email' WHERE username = '$user'");
				$_SESSION['msg'] = "Details updated successfully!";
		}
	}

	if(isset($_POST['password_change'])){
		$oldpass = md5($_POST['oldpass']);
		$newpass = $_POST['newpass'];
		$newpassconfirm = $_POST['newpassconfirm'];
		$user = $_SESSION['username'];

		if ($newpass != $newpassconfirm) {
			array_push($errors, "The two passwords do not match");
		}
		if (empty($newpass) || strlen($newpass) < 5) {
			array_push($errors, "New password is too short (at least 5 characters are required)");
		}

		$query = "SELECT * FROM users WHERE username='$user' AND password='$oldpass'";
		$results = mysqli_query($db, $query);

		if (mysqli_num_rows($results) == 1 && count($errors) == 0) {
			$pass = md5($newpass);
			$update_pass = $db->query("UPDATE users SET password = '$pass' WHERE username = '$user'");
			$_SESSION['msg'] = "Password updated successfully!";
		} else {
			array_push($errors, "Old password is incorrect!");
		}
	}
?>
