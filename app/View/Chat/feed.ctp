<h1>Chat System</h1>
<div class="container">
	<form class="form-group" method="POST">
		<div class="row">
			<div class="col-sm-1">Name</div>
			<div class="col-sm-6"><input type="text" class="form-control" name="name"> <br></div>
			<div class="col-sm-3"><input type="submit" class="btn btn-default" value="POST"></div>
		</div>
		<div class="row">
			<div class="col-sm-1">Message</div>
			<div class="col-sm-6"><textarea name="message" class="form-control"></textarea></div>
		</div>
		
		
	</form>
<div class="container">
	<?php foreach($data as $value): ?>
		<?php 
			// format time
			$date = new DateTime($value['tFeed']['create_at'], new DateTimeZone( 'UTC' ));
			$date->setTimezone( new DateTimeZone( 'Asia/Ho_Chi_Minh' ) );

		 ?>
		<span class="btn btn-primary" style="margin: 2px;"><?php echo $value['tFeed']['name'] . ": " .  $value['tFeed']['message'] . " " . $date->format('d/m/Y H:i:s') ?></span> <br>
	<?php endforeach; ?>
</div>
</div>
