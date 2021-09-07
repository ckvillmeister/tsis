<?php 

class authenticationController extends controller{

	private $model;
	
	public function index(){
		$settings_model = new settingsModel();
		$system_name = $settings_model->get_system_name();

		if ($this->is_session_empty()){
			$this->view()->render('login\login.php', array('system_name' => $system_name));
			//header('location:'.ROOT);
		}
		else{
			header('location:'.ROOT.'dashboard');
		}
	}

	public function validate_login(){
		$this->model = new authenticationModel();
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
			echo 1;
		}
		else{
			echo 0;
		}
		
	}

	public function logout(){
		session_destroy();
		header("Location: ".ROOT);
	}

}

?>