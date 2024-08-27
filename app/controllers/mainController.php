<?php

class mainController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();

			$this->view()->render('main/index.php', array('system_name' => $system_name));
		}
	}

	public function search_result(){
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
			
			if ($accessrole_model->check_access($role, 'quicksearch')){
			
				$supporter = isset($_POST['text_search_supporter']) ? $_POST['text_search_supporter'] : "";
				$ward_obj = new wardModel();
				$search_result = ($supporter) ? $ward_obj->retrieve_matched_supporter_names($supporter) : [];

				$this->view()->render('main/search_result.php', array('search_result' => $search_result, 'system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function logout(){
		$this->view()->render('login/login.php');
		session_destroy();
	}
}
?>