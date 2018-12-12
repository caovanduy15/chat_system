<?php
	echo $this->Form->create();
	$user_name = $this->Session->read('user_name');
	// print_r('Hi '.$_SESSION['user.name']);
	print_r('Hi '.$user_name);
	// echo $this->Form->input('name', array('label'=>'Name','required', ));
	echo $this->Form->input('message', 
		array('label'=>
			array('text'=>'Message',
				'style'=>array(
					'margin:0px 10px;',
					'color:red;')),
						'name'=>'mess',
						'cols'=>'40',
						'rows'=>'3',
						'style'=>array(
							'color:red;',
							'padding: 10px 0px 0px 20px;',
							'border:1px solid red;')));
	echo $this->Form->end('Update');
?>