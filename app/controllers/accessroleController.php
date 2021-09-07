<?php

class accessroleController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();

			$accessrole_model = new accessroleModel();
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];

   			if ($accessrole_model->check_access($role, 'roles')){
				$this->view()->render('maintenance/access_role/index.php', array('system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function access_rights(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();

			$accessrole_model = new accessroleModel();
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];

   			if ($accessrole_model->check_access($role, 'roles')){

				$roleid = isset($_GET['id']) ? $_GET['id'] : 0;
				
				$categories = $accessrole_model->get_access_categories(1);
				$roleinfo = $accessrole_model->get_access_role_info($roleid);

				$access_rights = array();

				foreach ($categories as $key => $category) {
					$accesscodes = $accessrole_model->get_access_codes($category['id'], $roleid);

					$access_rights[] = array('category_name' => $category['name'],
												'description' => $category['description'],
												'access_codes' => $accesscodes);
				}

				$this->view()->render('maintenance/access_role/manage_access_rights.php', array('system_name' => $system_name, 'access_rights' => $access_rights, 'rolename' => $roleinfo));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function get_access_roles(){
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$accessrole_model = new accessroleModel();
		$accessroles = $accessrole_model->get_access_roles($status);

		$accounts_model = new accountsModel();
  		$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
  		$role = $userinfo['role'];
  		$hasaccess = $accessrole_model->check_access($role, 'viewmanageaccessrights');
		
		$this->view()->render('maintenance/access_role/list.php', array('roles' => $accessroles, 'hasaccess' => $hasaccess));
	}

	public function get_access_role_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$accessrole_model = new accessroleModel();
		$roleinfo = $accessrole_model->get_access_role_info($id);

		echo json_encode($roleinfo);
	}

	public function process_access_role(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$rolename = isset($_POST['rolename']) ? $_POST['rolename'] : 0;
		$description = isset($_POST['description']) ? $_POST['description'] : 0;

		$accessrole_model = new accessroleModel();
		$result = $accessrole_model->process_access_role($id, $rolename, $description);
		echo $result;
	}

	public function toggle_role(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$accessrole_model = new accessroleModel();
		$result = $accessrole_model->toggle_role($id, $status);
		echo $result;
	}

	public function save_access_rights(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;
		$rights = isset($_POST['rights']) ? $_POST['rights'] : 0;
		
		$accessrole_model = new accessroleModel();
		$result = $accessrole_model->save_access_rights($id, $rights);
		echo $result;
	}
}
?>