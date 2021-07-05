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
    $username = $_SESSION['username'];


    $db->query("
        DELETE FROM likes WHERE username='{$username}' AND picture_id = '{$id}'
      ");
    //$number = "0";
    $resp = $db->query("SELECT COUNT(id) as nr FROM likes WHERE picture_id = '{$id}'");
    $pr = mysqli_fetch_assoc($resp);
    echo json_encode(array("da"=>$pr['nr']));
//header("Location: new.php");
?>
