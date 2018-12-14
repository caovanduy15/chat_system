<?php
	echo $this->Form->create("tFeed", array('type' => 'file'));
	$user_name = $this->Session->read('user.name');
	// print_r('Hi '.$_SESSION['user.name']);
	print_r('Hi '.$user_name);
	// echo $this->Form->input('name', array('label'=>'Name','required', ));
	echo $this->Form->input('message');
	echo $this->Form->input('photo', array('type' => 'file'));
	echo $this->Form->end('Update');
?>