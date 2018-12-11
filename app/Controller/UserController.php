<?php 
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
			$email_form = $_POST['e-mail'];
			$password_form = $_POST['password'];

			// get data to database
			$data = $this->tUser->find('all');

			$flag_valid_email = false;
			$flag_valid_password = false;

			// user email and user name login success
			$user_email = '';
			$user_name = '';

			// check email and password
			foreach ($data as $user) {
				if($user['tUser']['e-mail'] === $email_form) {
					$flag_valid_email = true;
					if($user['tUser']['password'] === $password_form) {
						$flag_valid_password = true;
						// get email login success from database
						$user_email = $user['tUser']['e-mail'];
						// get name login success from database
						$user_name = $user['tUser']['name'];
					}
				}
			}

			// Check flag
			if($flag_valid_email && $flag_valid_password) {
				session_start();
				//set session
				$_SESSION['user.email'] = $user_email;
				$_SESSION['user.name'] = $user_name;
				return $this->redirect(
					array(
						'controller' => 'Chat',
						'action' => 'feed'
					)
				);
			}

			// Error message email does not exist
			if(!$flag_valid_email) {
				return $this->Flash->error(__('Your email does not exist'));
			}

			// Error message password is incorrect
			if(!$flag_valid_password) {
				return $this->Flash->error(__('Your password is incorrect'));
			}

		}
	}

	public function logout() {
		// destory session data and go to login page
		session_start();
		$this->Session->destroy();
		return $this->redirect(array('action' => 'login'));
	}
	
}

 ?>
