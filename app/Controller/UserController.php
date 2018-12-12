<?php 
session_start();
class UserController extends AppController {
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
				return $this->redirect(array('action'=>'login'));	
			}
		}

	} 

	public function login() {

		if ($this->request->is('post')) {

			//get data to form
			$email_form = $this->request->data('e-mail');;
			$password_form = $this->request->data('password');;

			//validate email
			if (!filter_var($email_form, FILTER_VALIDATE_EMAIL)) {
				return $this->Flash->error(__('Invalid email format'));
			}

			// check e-mail in database
			$user = $this->tUser->find('first', array('conditions' => array('tUser.e-mail' => $email_form)));
			// check email and password
			if(!empty($user)) {

				// check password
				if ($user['tUser']['password'] === $password_form) {
					// set session
					session_start();
					$this->Session->write('user.email', $user['tUser']['e-mail']);
					$this->Session->write('user.name',  $user['tUser']['e-mail']);
					return $this->redirect(
						array(
							'controller' => 'Chat',
							'action' => 'feed'
						)
					);
				} else {
					// Error message password is incorrect
					return $this->Flash->error(__('Your password is incorrect'));
				}
			} else {
				// Error message email does not exist
				return $this->Flash->error(__('Your email does not exist'));
			} 
		}
	}

	public function logout() {
		// destory session data and go to login page
		$this->Session->destroy();
		return $this->redirect(array('action' => 'login'));
	}
	
}

 ?>
