<?php

class candidatesController extends controller{

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
			
			if ($accessrole_model->check_access($role, 'candidates')){
				$this->view()->render('maintenance/candidates/index.php', array('system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function profile(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$id = isset($_GET['id']) ? $_GET['id'] : '';
			$status = isset($_GET['status']) ? $_GET['status'] : '';

			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();
			
			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'viewcandidateprofile')){
				$barangays = $settings_model->get_barangays(1);
				$candidates_model = new candidatesModel();
				$candidateinfo = $candidates_model->get_candidate_info($id);
				$electionresults = $candidates_model->get_election_results($id, $status);

				$this->view()->render('maintenance/candidates/profile.php', array('system_name' => $system_name, 'profile' => $candidateinfo, 'results' => $electionresults, 'barangays' => $barangays));
			}
			else{
					$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
				}
		}
	}

	public function get_candidates(){
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$candidates_model = new candidatesModel();
		$candidates = $candidates_model->get_candidates($status);

		$accounts_model = new accountsModel();
  		$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
  		$role = $userinfo['role'];

  		$accessrole_model = new accessroleModel();
  		$hasaccess = $accessrole_model->check_access($role, 'viewcandidateprofile');
		
		$this->view()->render('maintenance/candidates/list.php', array('candidates' => $candidates, 'hasaccess' => $hasaccess));
	}

	public function get_candidate_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$candidates_model = new candidatesModel();
		$candidateinfo = $candidates_model->get_candidate_info($id);

		echo json_encode($candidateinfo);
	}

	public function process_candidate(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
		$middlename = isset($_POST['middlename']) ? $_POST['middlename'] : '';
		$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
		$isallied = isset($_POST['isallied']) ? $_POST['isallied'] : '';

		$candidates_model = new candidatesModel();
		$result = $candidates_model->process_candidate($id, $firstname, $middlename, $lastname, $isallied);
		echo $result;
	}

	public function toggle_candidate(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$candidates_model = new candidatesModel();
		$result = $candidates_model->toggle_candidate($id, $status);
		echo $result;
	}

	public function process_vote_record(){
		$candidateid = isset($_POST['id']) ? $_POST['id'] : 0;
		$barangay = isset($_POST['barangay']) ? $_POST['barangay'] : '';
		$votes = isset($_POST['votes']) ? $_POST['votes'] : '';
		$position = isset($_POST['position']) ? $_POST['position'] : '';
		$level = isset($_POST['level']) ? $_POST['level'] : '';
		$party = isset($_POST['party']) ? $_POST['party'] : '';
		$year = isset($_POST['year']) ? $_POST['year'] : '';
		$record_id = isset($_POST['record_id']) ? $_POST['record_id'] : '';

		$candidates_model = new candidatesModel();
		$result = $candidates_model->process_vote_record($record_id, $candidateid, $position, $level, $party, $barangay, $votes, $year);
		echo $result;
	}

	public function get_voter_record_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$candidates_model = new candidatesModel();
		$candidateinfo = $candidates_model->get_voter_record_info($id);

		echo json_encode($candidateinfo);
	}

	public function toggle_election_result(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$candidates_model = new candidatesModel();
		$result = $candidates_model->toggle_election_result($id, $status);
		echo $result;
	}
}
?>