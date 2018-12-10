<?php  
	class ChatController extends AppController
	{
		public $helpers = array('Html', 'Form','Flash');
		public $components = array('Flash');
		public $uses = array('tFeed');

		public function feed(){
			//$this->set('tFeed', $this->tFeed->find('all'));
			$data = $this->tFeed->find('all');
			// pr($data);
			// exit();
			$this ->set('data', $data);	

			if ($this->request->is('post')) 
			{
	            $today = date("Y-m-d H:i:s");
			         // 2001-03-10 17:16:18 (the MySQL DATETIME format)
			$this->request->data['time_at'] = $today;
            $this->tFeed->create();
            if ($this->tFeed->save($this->request->data)) {
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(array(
                	'controller' => 'chat',
                	'action' => 'feed'
                ));
            }
            $this->Flash->error(__('Unable to add your post.'));
			}
			
        }
	}
 ?>