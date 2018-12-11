<?php 
class ChatController extends AppController {
	public $uses = array("tFeed", "tUser");

	public function index() {

	}

	public function feed() {
		session_start();
		if(!isset($_SESSION['user.email'])) {
			return $this->redirect(
				array(
					'controller' => 'User',
					'action' => 'login'
				)
			);
		}	

		// get data from form and save data
		if ($this->request->is('post')) {
			// get time
			$today = date("Y-m-d H:i:s");
			// 2001-03-10 17:16:18 (the MySQL DATETIME format)
			$this->request->data['create_at'] = $today;
			$this->tFeed->create();
			if ($this->tFeed->save($this->request->data)) {
				$this->Flash->success(__('Your message has been seen.'));
			} else {
				$this->Flash->error(__('Unable to add your message.'));
			}
		}

		// get data from database and sort desc
		$data = $this->tFeed->find('all', array(
					'order'=>array('id DESC')));

		// Transfer data to view
		$this->set("data", $data);
	}

	
}

 ?>
