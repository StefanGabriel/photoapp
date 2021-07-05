<?php  if (count($errors) > 0) : ?>
	<div class="login100-error">
		<?php foreach ($errors as $error) : ?>
			<span><?php echo $error ?></span>
			<br>
		<?php endforeach ?>
	</div>
<?php  endif ?>
