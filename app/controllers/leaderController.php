<?php

class leaderController extends controller{

	public function barangay_leader(){
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
			
			if ($accessrole_model->check_access($role, 'brgyleader')){
				$this->view()->render('leader/barangay_leader/index.php', array('system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function purok_leader(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settingsObj = new settingsModel();
			$barangay = $settingsObj->get_barangays(1);
			$system_name = $settingsObj->get_system_name();

			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'purokleader')){
				$this->view()->render('leader/purok_leader/index.php', array('barangay' => $barangay, 'system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function get_barangay_leaders(){
		$leaderObj = new leaderModel();
		$leaders = $leaderObj->get_barangay_leaders();
		$this->view()->render('leader/barangay_leader/barangay_leader_list.php', array('leaders' => $leaders));
	}

	public function get_voters_list(){
		$barangay_id = $_POST['barangay'];
		$level = $_POST['level'];
		$voterObj = new voterModel();
		$voters = $voterObj->get_voters_list(array('barangay' => $barangay_id));

		if ($level=='purok'){
			$this->view()->render('leader/purok_leader/voters_list.php', array('voters' => $voters));
		}
		elseif ($level=='barangay'){
			$this->view()->render('leader/barangay_leader/voters_list.php', array('voters' => $voters));
		}
	}

	public function set_barangay_leader(){
		$voters_id = $_POST['voters_id'];
		$barangay_id = $_POST['barangay_id'];
		$leaderObj = new leaderModel();
		$result = $leaderObj->set_barangay_leader(array('voters_id' => $voters_id, 'barangay_id' => $barangay_id));

		$leaderObj = new leaderModel();
		$leaders = $leaderObj->get_barangay_leaders();
		$this->view()->render('leader/barangay_leader/barangay_leader_list.php', array('leaders' => $leaders));
	}

	public function get_purok_leaders(){
		$barangay_id = $_POST['barangay_id'];
		$leaderObj = new leaderModel();
		$leaders = $leaderObj->get_purok_leaders(array('barangay_id' => $barangay_id));
		$this->view()->render('leader/purok_leader/purok_leader_list.php', array('leaders' => $leaders));
	}

	public function set_purok_leader(){
		$voters_id = $_POST['voters_id'];
		$barangay_id = $_POST['barangay_id'];
		$purok_no = $_POST['purok_no'];
		$leaderObj = new leaderModel();
		$result = $leaderObj->set_purok_leader(array('voters_id' => $voters_id, 'barangay_id' => $barangay_id, 'purok_no' => $purok_no));

		$leaderObj = new leaderModel();
		$leaders = $leaderObj->get_purok_leaders(array('barangay_id' => $barangay_id));
		$this->view()->render('leader/purok_leader/purok_leader_list.php', array('leaders' => $leaders));
	}
}
?>