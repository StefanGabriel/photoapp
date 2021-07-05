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
		<title>Photo App</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/all.css" rel="stylesheet"></link>
		<link rel="stylesheet" type="text/css" href="css/util.css">
		<link rel="stylesheet" type="text/css" href="css/main.css">
		<script src="js/jquery-3.4.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
</head>
<?php include('navbar.php') ?>
<body>
	<?php
	$name = "";
	if(isset($_SESSION['username']))
	{
			$SessionUser = $_SESSION['username'];
			$query = "SELECT name FROM users WHERE username='$SessionUser'";
			$results = mysqli_query($db, $query);
			if (mysqli_num_rows($results) == 1) {
				$row = mysqli_fetch_assoc($results);
				$name = $row["name"];
			}
			else {
					echo "0 results";
			}
	}
	if(isset($_POST['btnUploadFile'])) {
		$file = addslashes(file_get_contents($_FILES["file"]["tmp_name"]));
		$user = $_SESSION['username'];
		$upload_date = date("Y-m-d H:i:sa");
		$query = "INSERT INTO pictures (username, date, image) VALUES ('$user', '$upload_date', '$file')";
		$upload = $db->query($query);
		// if($upload){
		// 	echo "File uploaded successfully.";
		// 		} else {
    //            echo "File upload failed, please try again.";
		// 		}
	}
 ?>
	<div class="container">
	    <div class="row">
	        <div class="col-lg-12 m-t-100 m-b-50">
	            <h1>Welcome,&nbsp;<?php echo $name ?>!</h1>
	        </div>
	    </div>
			<div class="col-md-12 no_padding_left">
				<h4>Upload new photo</h4>
				<br>
				<form method="POST" enctype="multipart/form-data" action="">
								<div class="col-md-9 text-left upload_divs_align no_padding_left">
										<div class="input-group">
												<label class="input-group-btn"> <span
																class="btn btn-primary"> Browse&hellip; <input
																type="file" name="file" id="customFile"
																style="display: none;" />
														</span>
												</label> <input type="text" class="form-control" id="customFileHolder"
																				readonly="true" />
										</div>
										<span class="help-block">
											Select the file to upload (in the jpg, tif or png format).
										</span>
								</div>
								<div class="col-md-2 upload_divs_align">
										<input type="submit" id="btnUploadFile" value="Upload" name="btnUploadFile" class="btn btn-primary" />
								</div>

				</form>
			</div>
	</div>

	<script>
				$(document).ready(function() {

			    $('#btnUploadFile').attr("disabled", true);
			    $("#customFile").change(function() {
			        var fileName = $(this).val().replace(/C:\\fakepath\\/i, '');

			        var ext = fileName.split('.').pop().toLowerCase();

			        if (ext == 'jpg' || ext == 'png' || ext == 'tif' || ext == 'pdf') {
			            $("#customFileHolder").val(fileName);
			            $('#btnUploadFile').removeAttr("disabled");
			        }
			    });

			    if ($('#divUploadSuccess').is(':visible')) {
			        $('#divUploadSuccess').show(0).delay(10000).hide(0);
			    }
				});
	</script>
</body>
</html>
