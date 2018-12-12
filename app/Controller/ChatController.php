<?php 
class ChatController extends AppController {
	public $uses = array("tFeed", "tUser");

	public function index() {

	}

	public function feed() {
		session_start();

		// If you are not logged in, navigate to the login page
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

	public function delete($id = null, $name = null) {
		// find message in database
		$message = $this->tFeed->findById($id);
		session_start();
		// If the message of the user is allowed to delete. otherwise not
		if($message['tFeed']['name'] === $_SESSION['user.name']) {
			if($this->tFeed->delete($id)) {
				$this->Flash->success(__('Your message deleted successfully.'));
			} else {
				$this->Flash->error(__('Your deleted message failed.'));
			}
		} else {
			$this->Flash->error(__('You do not have permission to delete.'));
		}

		return $this->redirect(array('action' => 'feed'));
	}	
}

 ?>
