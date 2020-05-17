<?php 

class loginController extends controller{

	private $model;
	
	public function index(){
		$this->view()->render('login\login.php');
	}

	public function validate_login(){
		$this->model = new loginModel();
		$username = $_POST['username'];
		$password = $_POST['password'];
		$datetime = date('Y-m-d H:i:s');
		$user = $this->model->validate_login(array('username' => $username, 'password' => $password, 'datetime' => $datetime));
		
		if (count($user) >= 1){
			$record = (object) $user;
			$data = (object) $record->info;
			if (count($user) >= 1){
				$_SESSION['user_id'] = $data->user_id;
				$_SESSION['firstname'] = $data->firstname;
				$_SESSION['middlename'] = $data->middlename;
				$_SESSION['lastname'] = $data->lastname;
			}
		}
		echo json_encode(count($user));
	}

}

?>