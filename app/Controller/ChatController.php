<?php 
	class ChatController extends AppController {
		public $uses = "tFeed";
	
		public function index() {
	
		}
	
		public function feed() {
			// get data from database and display data and sort desc
			$data = $this->tFeed->find('all', array(
	 					'order'=>array('id DESC')));
			$this->set("data", $data);
			// get data from form and save data
			if ($this->request->is('post')) {
				$today = date("Y-m-d H:i:s");
				         // 2001-03-10 17:16:18 (the MySQL DATETIME format)
				$this->request->data['create_at'] = $today;
	            $this->tFeed->create();
	            if ($this->tFeed->save($this->request->data)) {
	                $this->Flash->success(__('Your post has been saved.'));
	                return $this->redirect(array('action' => 'feed'));
	            }
	            $this->Flash->error(__('Unable to add your post.'));
	        }
		}
	
	
	}
	
	
	 ?>