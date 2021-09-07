<?php

class wardController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settingsObj = new settingsModel();
			$system_name = $settingsObj->get_system_name();
			$barangay = $settingsObj->get_barangays(1);
			
			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'warding')){
				$this->view()->render('ward/index.php', array('system_name' => $system_name, 'barangay' => $barangay));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function get_voters_list(){
		$voterObj = new voterModel();
		$barangay = $_POST['barangay'];
		$voters = $voterObj->get_voters_list(array('barangay' => $barangay));
		echo json_encode($voters, JSON_UNESCAPED_UNICODE);
	}

	public function check_if_supporter(){
		$wardObj = new wardModel();
		$position = $_POST['position'];
		$voterid = $_POST['id'];
		$result = $wardObj->check_if_supporter(array('position' => $position, 'voterid' => $voterid));

		echo $result;
		
	}

	public function save_ward(){
		$wardObj = new wardModel();
		$leader = $_POST['leader'];
		$members = $_POST['members'];
		$barangay = $_POST['barangay'];

		$result = $wardObj->save_ward(array('leader' => $leader, 'members' => $members, 'barangay' => $barangay));
		echo json_encode($result);
	}

	public function update_ward(){
		$wardObj = new wardModel();
		$wardid = $_POST['wardid'];
		$leader = $_POST['leader'];
		$members = $_POST['members'];
		$barangay = $_POST['barangay'];

		$result = $wardObj->update_ward(array('wardid' => $wardid, 'leader' => $leader, 'members' => $members, 'barangay' => $barangay));
		echo json_encode($result);
	}

	public function delete_ward(){
		$wardObj = new wardModel();
		$wardid = $_POST['wardid'];

		$result = $wardObj->delete_ward(array('wardid' => $wardid));
		echo json_encode($result);
	}

	public function get_wardleader(){
		$wardObj = new wardModel();
		$id = $_POST['id'];
		$name = $wardObj->get_wardleader(array('id' => $id));
		echo json_encode($name);
	}

	public function get_wardmembers(){
		$wardObj = new wardModel();
		$wardid = $_POST['wardid'];
		$members = $wardObj->get_wardmembers(array('wardid' => $wardid));
		echo json_encode($members);
	}

	public function get_ward_leaders_list(){
		$wardObj = new wardModel();
		$barangay = $_POST['barangay'];
		$leaders = $wardObj->get_ward_leaders_list(array('barangay' => $barangay));
		echo json_encode($leaders, JSON_UNESCAPED_UNICODE);
	}

	public function remove_ward_member(){
		$wardObj = new wardModel();
		$id = $_POST['id'];
		$wardObj->remove_ward_member(array('id' => $id));
	}

	public function view_ward(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$wardObj = new wardModel();
			$wardid = $_GET['wardid'];

			$members = $wardObj->get_wardmembers(array('wardid' => $wardid));
			$leader = $wardObj->get_leader($wardid);

			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();
			
			$this->view()->render('ward/ward.php', array('leader_info' => $leader, 'members_info' => $members, 'system_name' => $system_name));
		}
	}

}
?>