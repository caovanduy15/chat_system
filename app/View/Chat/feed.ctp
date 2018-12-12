<h1>Chat System</h1>

 <!-- UI chat -->
<div class="container">
	<form method="POST">
		<div class="row form-group">
			<div class="col-md-1"><label for="name">Name</label></div>
			<div class="col-md-6"><input type="text" class="form-control" name="name" id="name" value="<?php echo $_SESSION['user.name']; ?>"></div>
			<div class="col-md-1"><input type="submit" class="btn btn-default" value="POST"></div>
			<div class="col-md-1">
				<div class="btn">
					<?php
						echo $this->Html->link('Logout',
							array(
								'controller' => 'User',
								'action' => 'logout'
							)
						); 
					?>
				</div>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-1"><label for="message">Message</label></div>
			<div class="col-md-6"><textarea name="message" class="form-control" id="message"></textarea></div>
		</div>
	</form>

	<!-- UI display message -->
	<div class="container">

		 <!-- Display message -->
		<?php foreach($data as $value): ?>
			<?php 
				// name user
				$nameUser = $value['tFeed']['name'];

				// message
				$message = $value['tFeed']['message'];

				// format time
				$date = new DateTime($value['tFeed']['create_at'], new DateTimeZone( 'UTC' ));
				$date->setTimezone( new DateTimeZone( 'Asia/Ho_Chi_Minh' ) );
				$date = $date->format('d/m/Y H:i:s')
			 ?>
			<div class="container form-group">
				<div class="btn btn-primary"><?php echo  $nameUser . ": " . $message . " " . $date ?></div>
				<!-- button type="button" class="btn btn-secondary btn-sm">Edit</button> --> 
				<?php
					echo $this->html->link('edit',array(
						"controller"=>"Chat",
						"action"=>"edit",
						$value['tFeed']['id']
					)); 
				?>
			</div>
		<?php endforeach; ?>
	</div>
</div>
