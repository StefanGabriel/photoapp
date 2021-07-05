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
<?php
    $id = (int)$_GET['id'];
    $comm = (String)$_GET['comm'];
    $username = $_SESSION['username'];
    $comm_date = date("Y-m-d H:i:sa");
    $comm_time = date("d-m-Y H:i");
    $name = "";

    $resp = $db->query("
        INSERT INTO comments (username, picture_id, comment, date) VALUES
        ('{$username}', '{$id}', '{$comm}', '{$comm_date}')
      ");

      $SessionUser = $_SESSION['username'];
      $query = "SELECT name FROM users WHERE username='$username'";
      $results = mysqli_query($db, $query);
      if (mysqli_num_rows($results) == 1) {
        $row2 = mysqli_fetch_assoc($results);
        $name = $row2["name"];
      }
      else {
          echo "0 results";
      }

      if($resp){
        $value = array(
          "name"=>$name,
          "data"=>$comm_time
        );
        echo json_encode($value);
      }
      else {
        echo "Failed";
      }
?>
