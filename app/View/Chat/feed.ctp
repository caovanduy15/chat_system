<h1>Chat System</h1>
 <!-- UI chat -->
<div class="container">
	<form method="POST" enctype="multipart/form-data">
		<div class="row form-group">
			<div class="col-md-1"><label for="name">Name</label></div>
			<div class="col-md-6"><input type="text" class="form-control" name="name" id="name" value="<?php echo $this->Session->read('user.name'); ?>" disabled></div>
			<div class="col-md-1"><input type="submit" class="btn btn-default" value="POST"></div>
			<div>
				<?php echo $this->Form->input('photo', array('type' => 'file', 'label' => '')) ?>
			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-1"><label for="message">Message</label></div>
			<div class="col-md-6"><textarea name="message" class="form-control" id="message"></textarea></div>
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
	</form>

	<!-- UI display message -->
	<div class="container">

		 <!-- Display message -->
		<?php foreach($data as $value): ?>
			<?php
				// name user
				$nameUser = $value['tFeed']['name'];

				// base url
				$base_url = Router::url('/', true);

				// photo
				$photo = $base_url . 'app/webroot/img/upload/' . $value['tFeed']['image_file_name'];

				// message
				$message = $value['tFeed']['message'];

				// format time
				$date = new DateTime($value['tFeed']['create_at'], new DateTimeZone( 'UTC' ));
				$date->setTimezone( new DateTimeZone( 'Asia/Ho_Chi_Minh' ) );
				$date = $date->format('d/m/Y H:i:s')
			 ?>
			<div class="container form-group">
				<div class="btn btn-primary">
					<?php echo  $nameUser . ": " ?>
					<?php 
					if (!empty($value['tFeed']['image_file_name'])) {
						echo "<img src='";
						echo $photo;
						echo "' width='100px'/>";
					}
					 ?>
					<?php echo $message . " " . $date ?>
				</div>
				<?php
					if($this->Session->read('user.name')==$nameUser){
						echo $this->html->link('edit',array(
							"controller"=>"Chat",
							"action"=>"edit",
							$value['tFeed']['id']
					)); 
					}
				?>
				<?php
					if($this->Session->read('user.name') === $value['tFeed']['name']) {
						echo "<div class='btn btn-warning'>";
						echo $this->Form->postLink('Delete',
							array(
								'action' => 'delete',
								$value['tFeed']['id']
							),
							array('confirm' => 'Are you sure?')
						);
						echo "</div>";
					}
				?>
			</div>
		<?php endforeach; ?>
	</div>
</div>