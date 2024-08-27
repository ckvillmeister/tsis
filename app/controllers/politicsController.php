<?php

class politicsController extends controller{

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
			
			if ($accessrole_model->check_access($role, 'politician')){
				$this->view()->render('politics/politician/index.php', array('system_name' => $system_name));
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
				$politics_model = new politicsModel();
				$candidateinfo = $politics_model->get_candidate_info($id);
				$electionresults = $politics_model->get_election_results($id, $status);
				$year = $politics_model->get_year();

				$this->view()->render('politics/politician/profile.php', array('system_name' => $system_name, 'profile' => $candidateinfo, 'results' => $electionresults, 'barangays' => $barangays, 'year' => $year));
			}
			else{
					$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
				}
		}
	}

	public function get_candidates(){
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$politics_model = new politicsModel();
		$candidates = $politics_model->get_candidates($status);

		$accounts_model = new accountsModel();
  		$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
  		$role = $userinfo['role'];

  		$accessrole_model = new accessroleModel();
  		$hasaccess = $accessrole_model->check_access($role, 'viewcandidateprofile');
		
		$this->view()->render('politics/politician/list.php', array('candidates' => $candidates, 'hasaccess' => $hasaccess));
	}

	public function get_candidate_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$politics_model = new politicsModel();
		$candidateinfo = $politics_model->get_candidate_info($id);

		echo json_encode($candidateinfo);
	}

	public function process_candidate(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
		$middlename = isset($_POST['middlename']) ? $_POST['middlename'] : '';
		$lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
		$isallied = isset($_POST['isallied']) ? $_POST['isallied'] : '';

		$politics_model = new politicsModel();
		$result = $politics_model->process_candidate($id, $firstname, $middlename, $lastname, $isallied);
		echo $result;
	}

	public function toggle_candidate(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$politics_model = new politicsModel();
		$result = $politics_model->toggle_candidate($id, $status);
		echo $result;
	}

	public function party(){
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
			
			if ($accessrole_model->check_access($role, 'politician')){
				$this->view()->render('politics/party/index.php', array('system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function store_party(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$code = isset($_POST['code']) ? $_POST['code'] : '';
		$name = isset($_POST['name']) ? $_POST['name'] : '';

		$politics_model = new politicsModel();
		$result = $politics_model->store_party($id, $code, $name);
		echo $result;
	}

	public function get_parties(){
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$politics_model = new politicsModel();
		$parties = $politics_model->get_parties($status);
		
		$this->view()->render('politics/party/parties.php', array('parties' => $parties));
	}

	public function manage(){
		$id = isset($_GET['id']) ? $_GET['id'] : 0;

		$settings_model = new settingsModel();
		$system_name = $settings_model->get_system_name();


		$politics_model = new politicsModel();
		$party = $politics_model->get_party_info($id);
		$candidates = $politics_model->get_candidates(1, 1);
		$allied_party = $politics_model->allied_party();

		$this->view()->render('politics/party/manage.php', array('party' => $party, 
																'candidates' => $candidates,
																'positions' => $politics_model->positions,
																	'system_name' => $system_name,
																	'allied_party' => $allied_party));
	}

	public function slate(){
		$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$politics_model = new politicsModel();
		$members = $politics_model->get_slate_members($id, $status);
		$partyinfo = $politics_model->get_party_info($id);

		$this->view()->render('politics/party/slate.php', array('members' => $members, 'partyid' => $id, 'partyinfo' => $partyinfo));
	}

	public function party_add_member(){
		$id = isset($_GET['partyid']) ? $_GET['partyid'] : 0;
		$politician = isset($_POST['politician']) ? $_POST['politician'] : '';
		$position = isset($_POST['position']) ? $_POST['position'] : '';

		$politics_model = new politicsModel();
		$result = $politics_model->party_add_member($id, $politician, $position);
	}

	public function party_remove_member(){
		$memberid = isset($_POST['memberid']) ? $_POST['memberid'] : 0;

		$politics_model = new politicsModel();
		$result = $politics_model->party_remove_member($memberid);
	}

	public function toggle_party(){
		$id = isset($_POST['partyid']) ? $_POST['partyid'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;

		$politics_model = new politicsModel();
		$politics_model->toggle_party($id, $status);

		echo ROOT.'politics/party';
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

		$politics_model = new politicsModel();
		$result = $politics_model->process_vote_record($record_id, $candidateid, $position, $level, $party, $barangay, $votes, $year);
		echo $result;
	}

	public function get_voter_record_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;

		$politics_model = new politicsModel();
		$candidateinfo = $politics_model->get_voter_record_info($id);

		echo json_encode($candidateinfo);
	}

	public function toggle_election_result(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$politics_model = new politicsModel();
		$result = $politics_model->toggle_election_result($id, $status);
		echo $result;
	}

	public function set_party_allied(){
		$id = isset($_POST['id']) ? $_POST['id'] : 0;
		$status = isset($_POST['status']) ? $_POST['status'] : 0;
		
		$politics_model = new politicsModel();
		$result = $politics_model->set_party_allied($id, $status);
		echo $result;
	}

}
?>