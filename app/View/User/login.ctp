<div class="container">
	<h1>Login</h1>
	<form method="POST">
		<div class="row form-group">
			<div class="col-md-1"><label for="e-mail">Email</label></div>
			<div class="col-md-6"><input type="text" class="form-control" name="e-mail" id="email" required></div>
		</div>

		<div class="row form-group">
			<div class="col-md-1"><label for="password">Password</label></div>
			<div class="col-md-6"><input type="password" class="form-control" name="password" id="password" required></div>
		</div>
		<div class="row form-group">
			<div class="col-md-5"></div>
			<div class="col-md-1">
				<div class="btn">
					<?php
						echo $this->Html->link('Regist',
							array(
								'controller' => 'User',
								'action' => 'regist'
							)
						); 
					?>
				</div>
			</div>
			<div class="col-md-1"><input type="submit" class="btn btn-primary" value="Login"></div>
		</div>
	</form>
</div>