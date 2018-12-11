<?php
	class UserController extends AppController{
		public $uses = "tUser";
		public function regist(){
			// set up database connection
			$data = $this->tUser->find('all');
			$this->set("data", $data);
			// get data from form and save data
			if ($this->request->is('post')){
				$this->tUser->create();
				if ($this->tUser->save($this->request->data)){
					$this->Flash->success(__('Regist successfully'));
					// return $this->redirect(array('action'=>'login'));	
				}
			}

		}
		public function login(){}
	}
?>