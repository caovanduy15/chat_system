<?php
class ChatController extends AppController {
	public $uses = array("tFeed", "tUser");

	public function index() {

	}



	//up
	 public function initialize(){
        parent::initialize();
        
        // Include the FlashComponent
        $this->loadComponent('Flash');
        
        // Load Files model
        $this->loadModel('t_feed');
        
        // Set the layout
        $this->layout = 'frontend';
    }
    //feed


	public function feed() {

		// If you are not logged in, navigate to the login page
		session_start();
		if(!$this->Session->check('user.email')) {
			return $this->redirect(
				array(
					'controller' => 'User',
					'action' => 'login'
				)
			);
		}	
		// get data from form and save data
		if ($this->request->is('post')) {			


			// 
			$this->request->data['name'] = $this->Session->read('user.name');

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
			//upload
			$target_dir = "img/upload/";
			$target_file = $target_dir . basename($_FILES["tFeed"]["image_file_name"]);
			$uploadOk = 1;
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
			// Check if image file is a actual image or fake image
			if(isset($_POST["submit"])) {
			    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
			    if($check !== false) {
			        echo "File is an image - " . $check["mime"] . ".";
			        $uploadOk = 1;
			    } else {
			        echo "File is not an image.";
			        $uploadOk = 0;
			    }
			}

			//upload
			// if(!empty($this->request->data['file']['name'])){
   //              echo 'HaHa';
   //              $fileName = $this->request->data['file']['name'];
   //              $uploadPath = 'img/upload/';
   //              $uploadFile = $uploadPath.$fileName;
   //              if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
   //                  $uploadData = $this->Files->newEntity();
   //                  $uploadData->name = $fileName;
   //                  $uploadData->path = $uploadPath;
   //                  $uploadData->created = date("Y-m-d H:i:s");
   //                  $uploadData->modified = date("Y-m-d H:i:s");
   //                  if ($this->Files->save($uploadData)) {
   //                      $this->Flash->success(__('File has been uploaded and inserted successfully.'));
   //                  }else{
   //                      $this->Flash->error(__('Unable to upload file, please try again.'));
   //                  }
   //              }else{
   //                  $this->Flash->error(__('Unable to upload file, please try again.'));
   //              }
   //          }else{
   //              $this->Flash->error(__('Please choose a file to upload.'));
   //          }
            // $this->set('uploadData', $uploadData);

		}



		



		// get data from database and sort desc
		$data = $this->tFeed->find('all', array(
					'order'=>array('id DESC')));

		// Transfer data to view
		$this->set("data", $data);
	}
	public function edit($id=null){
		$feed = $this->tFeed->findById($id);
		if(!$this->request->data){
			$this->request->data = $feed;
		}
		if($this->request->is(array('post','put'))){
			$this->tFeed->id = $id;
			$today = date("Y-m-d H:i:s");
			$this->request->data['tFeed']['update_at'] = $today;
			if ($this->tFeed->save($this->request->data)){
				$this->Flash->success(__('Your message has been changed'));
				return $this->redirect(array('action' =>'feed'));
			}
			$this->Flash->error(__('Unable to change'));
		}
	}
	public function delete($id = null) {
		// find message in database
		$message = $this->tFeed->findById($id);
		session_start();
		// If the message of the user is allowed to delete. otherwise not
		if($message['tFeed']['name'] === $this->Session->read('user.name')) {
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
