<?php

class settingsController extends controller{
	
	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new SettingsModel();
			$settings = $settings_model->get_settings();
			$system_name = $settings_model->get_system_name();
			
			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'system')){
				$this->view()->render('maintenance/system_settings/index.php', array('settings' => $settings, 'system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function barangay(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new SettingsModel();
			$settings = $settings_model->get_settings();
			$system_name = $settings_model->get_system_name();
			
			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'barangay')){
				$this->view()->render('maintenance/barangay/index.php', array('system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function save_settings(){
		$settings_model = new SettingsModel();

		$name = $_POST['name'];
		$year = $_POST['year'];
		$result = $settings_model->save_settings($name, $year);
		echo $result;
	}

	public function get_barangays(){
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$settings_model = new SettingsModel();
		$barangays = $settings_model->get_barangays($status);
		
		$this->view()->render('maintenance/barangay/list.php', array('barangays' => $barangays));
	}

	public function process_barangay(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$barangay = isset($_POST['barangay']) ? $_POST['barangay'] : '';

		$settings_model = new SettingsModel();
		$result = $settings_model->process_barangay($id, $barangay);
		echo $result;
	}

	public function get_barangay_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$settings_model = new SettingsModel();
		$barangayinfo = $settings_model->get_barangay_info($id);

		echo json_encode($barangayinfo);
	}

	public function toggle_barangay(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$settings_model = new SettingsModel();
		$result = $settings_model->toggle_barangay($id, $status);
		echo $result;
	}

	public function back_up_database(){
		$str = exec('start /B '.$_SERVER['DOCUMENT_ROOT'].ROOT.'\app\lib\database-backup.bat'); 
		echo 1;
	}

	public function save_system_image(){
		$set_name = isset($_GET['set_name']) ? $_GET['set_name'] : "";
		$file = $_FILES['file']['tmp_name'];
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		
		$path = 'public/image/'.$_FILES['file']['name'];
		$dist = $_SERVER['DOCUMENT_ROOT'].ROOT.'public/image/'.$_FILES['file']['name'];
		move_uploaded_file($file, $dist);

		$settings_model = new SettingsModel();
		echo 1;  $settings_model->update_image($path, $set_name);
	}

}

?>