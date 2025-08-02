<?php

class wardController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settingsObj = new settingsModel();
			$system_name = $settingsObj->get_system_name();

			$this->view()->render('ward/index.php', array('system_name' => $system_name));
		}
	}

	public function regular(){
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
				$this->view()->render('ward/regular.php', array('system_name' => $system_name, 'barangay' => $barangay));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function sk(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settingsObj = new settingsModel();
			$barangay = $settingsObj->get_barangays(1);

			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();
			
			$this->view()->render('ward/sk.php', ['system_name' => $system_name, 'barangay' => $barangay]);
		}
	}

	public function special(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settingsObj = new settingsModel();
			$system_name = $settingsObj->get_system_name();
			$barangay = $settingsObj->get_barangays(1);

			$politics_model = new politicsModel();
			$parties = $politics_model->get_parties(1);
			
			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			// if ($accessrole_model->check_access($role, 'warding')){
				$this->view()->render('ward/special.php', array('system_name' => $system_name, 
																'barangay' => $barangay,
																'parties' => $parties));
			// }
			// else{
			// 	$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			// }
		}
	}

	public function get_voters_list(){
		$voterObj = new voterModel();
		$barangay = $_POST['barangay'];
		$voters = $voterObj->get_voters_list(array('brgy' => $barangay));
		echo json_encode($voters, JSON_UNESCAPED_UNICODE);
	}

	public function check_if_supporter(){
		$wardObj = new wardModel();
		$position = $_POST['position'];
		$voterid = $_POST['id'];
		$result = $wardObj->check_if_supporter(array('position' => $position, 'voterid' => $voterid));
		
		echo ($result) ? $result : 0;
	}

	public function check_if_sk_supporter(){
		$wardObj = new wardModel();
		$voterid = $_POST['id'];
		$result = $wardObj->check_if_sk_supporter(array('voterid' => $voterid));

		echo ($result) ? $result : 0;
	}

	public function save_ward(){
		$wardObj = new wardModel();
		$leader = $_POST['leader'];
		$members = $_POST['members'];
		$barangay = $_POST['barangay'];

		$result = $wardObj->save_ward(array('leader' => $leader, 'members' => $members, 'barangay' => $barangay));
		echo json_encode($result);
	}

	public function save_sk(){
		$wardObj = new wardModel();
		$members = $_POST['members'];
		$barangay = $_POST['barangay'];

		$result = $wardObj->save_sk(array('members' => $members, 'barangay' => $barangay));
		echo json_encode($result);
	}

	public function save_special_ops(){
		$wardObj = new wardModel();
		$candidates = $_POST['candidates'];
		$voters = $_POST['specials'];
		$barangay = $_POST['barangay'];
		$party = $_POST['party'];

		$result = $wardObj->save_special_ops($barangay, $candidates, $voters, $party);
		echo $result;
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

	public function get_sk_members(){
		$wardObj = new wardModel();
		$barangayid = $_POST['barangayid'];
		$members = $wardObj->get_sk_list(array('barangayid' => $barangayid));
		echo json_encode($members);
	}


	public function get_sk_list(){
		$voterObj = new voterModel();
		$barangay = $_POST['barangay'];
		$voters = $voterObj->get_voters_list(array('brgy' => $barangay, 'sk' => '1'));
		echo json_encode($voters, JSON_UNESCAPED_UNICODE);
	}

	public function remove_sk_supporter(){
		$wardObj = new wardModel();
		$id = isset($_POST['id']) ? $_POST['id'] : null;
		$brgy = isset($_POST['brgy']) ? $_POST['brgy'] : null;

		echo $wardObj->remove_sk_supporter(array('id' => $id, 'brgy' => $brgy));		
	}

	public function slate(){
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$politics_model = new politicsModel();
		$members = $politics_model->get_slate_members($id, $status);
		
		echo json_encode($members);
	}

	public function get_special_supporters(){
		$party = isset($_POST['party']) ? $_POST['party'] : null;
		$barangay = isset($_POST['barangay']) ? $_POST['barangay'] : null;

		$wardObj = new wardModel();
		$supporters = $wardObj->get_special_supporters($party, $barangay);
		echo json_encode($supporters);
	}

	public function remove_special_supporter(){
		$party = $_POST['party_id'];
		$supporter = $_POST['supporter_id'];
		$candidate = $_POST['candidate_id'];

		$wardObj = new wardModel();
		$result = $wardObj->remove_special_supporter($party, $supporter, $candidate);
		echo $result;
	}

	function uploadLeadersList(){
		$wardModel = new wardModel();
		$year = $wardModel->get_year();
		$list = $wardModel->getAllLeaders($year);
		
		echo json_encode(['list' => $list, 'year' => $year]);
	}

	function uploadMembersList(){
		$wardModel = new wardModel();
		$year = $wardModel->get_year();
		$list = $wardModel->getAllMembers($year);
		
		echo json_encode(['list' => $list, 'year' => $year]);
	}
}
?>