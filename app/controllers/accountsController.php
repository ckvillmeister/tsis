<?php

class accountsController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();

			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'accounts')){
				$this->view()->render('maintenance/accounts/index.php', array('system_name' => $system_name, 'roles' => $accessroles));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function get_user_accounts(){
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$accounts_model = new accountsModel();
		$useraccounts = $accounts_model->get_user_accounts($status);
		
		$this->view()->render('maintenance/accounts/list.php', array('users' => $useraccounts));
	}

	public function get_user_account_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$accounts_model = new accountsModel();
		$userinfo = $accounts_model->get_user_info($id);

		echo json_encode($userinfo);
	}

	public function process_user_account(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$username = isset($_POST['username']) ? $_POST['username'] : '';
		$password = isset($_POST['password']) ? $_POST['password'] : '';
		$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
		$middlename = isset($_POST['middlename']) ? $_POST['middlename'] : '';
		$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
		$extension = isset($_POST['extension']) ? $_POST['extension'] : '';
		$role = isset($_POST['role']) ? $_POST['role'] : '';

		$accounts_model = new accountsModel();
		$result = $accounts_model->process_user_account($id, $username, $password, $firstname, $middlename, $lastname, $extension, $role);
		echo $result;
	}

	public function toggle_user(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$accounts_model = new accountsModel();
		$result = $accounts_model->toggle_user($id, $status);
		echo $result;
	}

	public function reset_password(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$password = isset($_POST['password']) ? $_POST['password'] : 0;
		
		$accounts_model = new accountsModel();
		$result = $accounts_model->reset_password($id, $password);
		echo $result;
	}
}
?>