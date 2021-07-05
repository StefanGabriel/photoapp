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
  $usr = $_SESSION['username'];
  $pictures = [];
	$picturesQuery = $db->query("
      SELECT pictures.id, pictures.image, COUNT(likes.id) as num_likes, users.name, pictures.date
      FROM pictures
      LEFT JOIN likes
      ON pictures.id = likes.picture_id

      INNER JOIN users
      ON users.username = pictures.username

      GROUP BY pictures.id
      ORDER BY pictures.date desc
  ");


  while($row = $picturesQuery->fetch_object()){
    $pictures[] = $row;
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
</head>
<style type="text/css">

        .user {
            font-weight: bold;
            color: black;
        }

        .time {
            color: gray;
        }

        .text1 {
            color: black;
            font-weight: normal;
        }

        .userComment {
            color: #000;
            font-size: 20px;
        }
    </style>
<?php include('navbar.php') ?>
<body>
	<div class="container m-t-50">
      <?php foreach ($pictures as $picture ): ?>
        <div class = "picture">
          <div class="row m-l-150">
              <h2><?php echo $picture->name; ?></h2>
          </div>
          <div class="v_a m-l-150 ">uploaded a new photo on <?php echo date("d-m-Y H:i", strtotime($picture->date)); ?></div>
          <br>
          <div class="row justify-content-center">
              <img src="data:image/jpeg;base64,<?php echo base64_encode($picture->image); ?>" height=auto width="800" class="img-thumnail img-responsive" />
          </div>
          <br>
          <div class ="">
            <?php
                $usr = $_SESSION['username'];
                $number = "";
                $query = $db->query("
                    SELECT COUNT(id) as nr
                    FROM likes
                    WHERE username = '{$usr}' AND picture_id = '{$picture->id}'
                ");
                $pr = mysqli_fetch_assoc($query);
                $number = $pr["nr"];
            ?>
            <?php if(!$number) : ?>
                <span class="far fa-thumbs-up like fa-3x m-l-150" data-id="<?php echo $picture->id; ?>"></span>
                <span class="fas fa-thumbs-up unlike hide fa-3x m-l-150" data-id="<?php echo $picture->id; ?>"></span>
            <?php else : ?>
                <span class="fas fa-thumbs-up unlike fa-3x m-l-150" data-id="<?php echo $picture->id; ?>"></span>
                <span class="far fa-thumbs-up like hide fa-3x m-l-150" data-id="<?php echo $picture->id; ?>"></span>
            <?php endif; ?>
            &nbsp;&nbsp;&nbsp;&nbsp;
              <span class="nush<?php echo $picture->id; ?>" id="nush<?php echo $picture->id; ?>"><?php echo $picture->num_likes; ?> people liked this picture.</span>
          </div>
          <br>
          <div class="v_a m-l-140">
              <div class="col-md-10">
                  <textarea class="form-control" id="comm<?php echo $picture->id; ?>" placeholder="Add Public Comment" cols="30" rows="2"></textarea><br>
                  <button style="float:right" class="btn-primary btn addComment" onclick="isReply = false;" id="addComment" data-id="<?php echo $picture->id; ?>">Add Comment</button>
              </div>
          </div>
          <br>
          <div class="media comment-box display_new_line m-l-130 col-md-9">
                <div id="mai<?php echo $picture->id; ?>"></div>
                  <?php
                  $commQuery= $db->query("
                        SELECT users.name, comments.comment, comments.date
                        FROM comments
                        INNER JOIN users
                        ON users.username = comments.username
                        where comments.picture_id = '$picture->id'
                        ORDER BY comments.date desc
                  ");

                  while($row1 = $commQuery->fetch_object()){
                    $comm_date = date("d-m-Y H:i", strtotime($row1->date));
                    echo '
                    <div class="media">
                        <div class="media-left">
                            <a href="#">
                                <img class="img-responsive user-photo" src="https://ssl.gstatic.com/accounts/ui/avatar_2x.png">
                            </a>
                        </div>
                        <div class="media-body comment_break">
                            <h4 class="media-heading">'.$row1->name.'</h4>
                            <p>'.$row1->comment.'</p>
                            <span class="text1 comment_notes v_a float-right"> comment added on ' .$comm_date.'</span>
                        </div>
                    </div>
                    <br>
                    ';
                  }
                  ?>
        </div>
        </div>
        <br><br><br><br>
      <?php endforeach; ?>

	</div>
	<script src="js/jquery-3.4.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
  <script>
  $('.like').click(function (e) {
      var this_var = $(this);
      var id = this_var.data("id");
      $.ajax({
          url: "like.php?id=" + id,
          type: 'GET',
          dataType: 'JSON',
          success: function (e1) {
              this_var.addClass('hide');
              this_var.siblings().removeClass('hide');
              var nu = "#nush" + id;
              $(nu).text(e1.da + " people liked this picture");
            }
      });
  });

  $('.addComment').click(function (e) {
      var this_var = $(this);
      var id = this_var.data("id");
      var nu = "#comm" + id;
      var comment = $(nu).val();
      $(nu).val('');
      if (comment.length >= 2 && comment.length <= 255) {
          $.ajax({
              url: "add_comm.php?id=" + id + "&comm=" + comment,
              type: 'GET',
              dataType: 'JSON',
              success: function (e1) {
                  var mai = "#mai" + id;
                  var toDisplay = "<div class='media'>"
                      + "<div class='media-left'>"
                      +    "<a href='#'>"
                      +        "<img class='img-responsive user-photo' src='https://ssl.gstatic.com/accounts/ui/avatar_2x.png'>"
                      +    "</a>"
                      + "</div>"
                      + "<div class='media-body comment_break'>"
                      +    "<h4 class='media-heading'>" + e1.name + "</h4>"
                      +    "<p>" + comment + "</p>"
                      +    "<span class='text1 comment_notes v_a float-right'> comment added on " + e1.data + "</span>"
                      + "</div>"
                      + "</div>"
                      + "<br>";
                  $(toDisplay).insertAfter(mai);
                }
          });
      } else {
        alert('Comment invalid.');
    }
  });

  $('.unlike').click(function (e) {
      var this_var = $(this);
      var id = $(this).data("id");

      $.ajax({
          url: "unlike.php?id=" + id,
          type: 'GET',
          dataType: 'JSON',
          success: function (e1) {
              this_var.addClass('hide');
              this_var.siblings().removeClass('hide');
              var nu = "#nush" + id;
              $(nu).text(e1.da + " people liked this picture");
            }
      });
  });
  </script>
</body>
</html>
