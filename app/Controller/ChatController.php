<?php
session_start();
class ChatController extends AppController {
	public $uses = array("tFeed", "tUser", 'File', 'Utility');

	public function feed() {
		// If you are not logged in, navigate to the login page
		if(!$this->Session->check('user.email')) {
			return $this->redirect(array('controller' => 'User', 'action' => 'login'));
		}
		// get data from form and save data
		if ($this->request->is('post')) {
			// check empty message
			if(empty($this->request->data['message']) && $this->request->data['photo']['error'] != 0) {
				$this->Flash->error(__('Empty message'));
			} else {
				$this->request->data['name'] = $this->Session->read('user.name');
				// check send image
				if($this->request->data['photo']['error'] == 0) {
					$photo_name = time();
					// add file extension
					switch ($this->request->data['photo']['type']) {
						case 'image/jpeg':
							$photo_name .= ".jpg";
							break;
						case 'image/png':
							$photo_name .= ".png";
							break;
						case 'image/gif':
							$photo_name .= ".gif";
							break;
					}
					// path save photo
					$photo_path = IMAGES . 'upload/' . $photo_name;
					$this->request->data['image_file_name'] = $photo_name;
					// save image
					move_uploaded_file($this->request->data['photo']['tmp_name'], $photo_path);
				}
				// get time
				$today = date("Y-m-d H:i:s");
				// 2001-03-10 17:16:18 (the MySQL DATETIME format)
				$this->request->data['create_at'] = $today;
				$this->request->data['update_at'] = $today;
				$this->tFeed->create();
				if ($this->tFeed->save($this->request->data)) {
					$this->Flash->success(__('Your message has been seen.'));
				} else {
					$this->Flash->error(__('Unable to add your message.'));
				}
			}
		}
		// get data from database and sort desc
		$data = $this->tFeed->find('all', array('order'=>array('id DESC')));
		// Transfer data to view
		$this->set("data", $data);
	}

	public function edit($id=null) {
		$feed = $this->tFeed->findById($id);
		if (!$this->request->data) {
			$this->request->data = $feed;
		}

		if($this->request->is(array('post','put'))) {
			if($this->request->data['tFeed']['photo']['error'] == 0) {
				$photo_name = time();
				// add file extension
				switch ($this->request->data['tFeed']['photo']['type']) {
					case 'image/jpeg':
						$photo_name .= ".jpg";
						break;
					case 'image/png':
						$photo_name .= ".png";
						break;
					case 'image/gif':
						$photo_name .= ".gif";
						break;
				}
				// path save photo
				$photo_path = IMAGES . 'upload/' . $photo_name;
				$this->request->data['tFeed']['image_file_name'] = $photo_name;
				// save image
				if(!empty($feed['tFeed']['image_file_name'])) {
					if(move_uploaded_file($this->request->data['tFeed']['photo']['tmp_name'], $photo_path)) {
						$this->Flash->success(__('Update your image successful'));
						$old_photo_path = IMAGES.'upload/'.$feed['tFeed']['image_file_name'];
						$file = new File($old_photo_path, false, 0777);
						if($file->delete()) {
							$this->Flash->success(__('Delete your old photos successfully'));
						} else {
							$this->Flash->success(__('Delete your old photos failed'));
						}
					}
				} else {
					move_uploaded_file($this->request->data['tFeed']['photo']['tmp_name'], $photo_path);
					$this->Flash->success(__('Update your image successful'));
				}
			}
			$this->tFeed->id = $id;
			$today = date("Y-m-d H:i:s");
			$this->request->data['tFeed']['update_at'] = $today;

			if ($this->tFeed->save($this->request->data)){
				$this->Flash->success(__('Your message has been changed'));
				return $this->redirect(array('action' => 'feed'));
			}

			$this->Flash->error(__('Unable to change'));
		}
	}

	public function delete($id = null) {
		// find message in database
		$message = $this->tFeed->findById($id);
		// If the message of the user is allowed to delete. otherwise not
		if ($message['tFeed']['name'] === $this->Session->read('user.name')) {
			if ($this->tFeed->delete($id)) {
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