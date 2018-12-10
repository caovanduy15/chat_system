
<h1>Feed</h1> <br>
<form method="post" >
Name: <input type="text" name="name" style="wide:75%;" >
<input type="submit" style="float:left;">
</form><br><br>
Message: 
<br>
<textarea rows="4" cols="50" name="message" form="usrform">
Enter text here...</textarea>


	 <!-- Display message -->
	
	<?php foreach($data as $feed): ?>
		<?php 
			
			$nameUser = $feed['tFeed']['name'];
			// message
			$message = $feed['tFeed']['message'];
			// format time
			$date = new DateTime($feed['tFeed']['create_at'], new DateTimeZone( 'UTC' ));
			$date->setTimezone( new DateTimeZone( 'Asia/Ho_Chi_Minh' ) );
			$date = $date->format('d/m/Y H:i:s')
		 ?>
		<div class="container form-group">
			<div class="btn btn-primary"><?php echo  $nameUser . ": " . $message . " " . $date ?></div>
			
			<div class="btn btn-danger">Delete</div> -->
		</div>
	<?php endforeach; ?>





