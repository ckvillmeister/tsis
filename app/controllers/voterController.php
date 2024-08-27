<?php

class voterController extends controller{

	private $voterObj;

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();
			$barangays = $settings_model->get_barangays(1);

			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'voters')){
				$this->view()->render('voter/index.php', array('system_name' => $system_name, 'barangays' => $barangays));
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
			$voterid = isset($_GET['voterid']) ? $_GET['voterid'] : "";

			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();
			$barangay = $settings_model->get_barangays(1);

			$voter_model = new voterModel();
			$profile = $voter_model->get_voter_profile($voterid);

			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'viewsupporterprofile')){
				$this->view()->render('voter/profile.php', array('system_name' => $system_name, 'barangay' => $barangay,  'profile' => $profile,));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function get_voter_info(){
		$id = isset($_POST['id']) ? $_POST['id'] : '';

		$voter_model = new voterModel();
		$profile = $voter_model->get_voter_profile($id);
		echo json_encode($profile);
	}

	public function get_voters_list(){
		//$content = file_get_contents(PATH_VIEW.'/voter/table.php');
		//echo $content;
		$brgy = isset($_POST['brgy']) ? $_POST['brgy'] : '';

		$this->voterObj = new voterModel();
		$voters = $this->voterObj->get_voters_list(['brgy' => $brgy]);
		$this->view()->render('voter/list.php', array('voters' => $voters));
	}

	public function save_voter_profile(){
		$voter_sys_id = isset($_POST['voters_sys_id']) ? $_POST['voters_sys_id'] : '';
		$fname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
		$mname = isset($_POST['middlename']) ? $_POST['middlename'] : '';
		$lname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
		$ext = isset($_POST['suffix']) ? $_POST['suffix'] : '';
		$vin = isset($_POST['vin']) ? $_POST['vin'] : '';
		$vno = isset($_POST['vno']) ? $_POST['vno'] : '';
		$precinctno = isset($_POST['precinct_no']) ? $_POST['precinct_no'] : '';
		$clusterno = isset($_POST['cluster_no']) ? $_POST['cluster_no'] : '';
		$purok = isset($_POST['purok_no']) ? $_POST['purok_no'] : '';
		$barangay = isset($_POST['barangay']) ? $_POST['barangay'] : '';
		$birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : '';
		$sex = isset($_POST['gender']) ? $_POST['gender'] : '';

		$contact = isset($_POST['contact']) ? $_POST['contact'] : '';
		$work = isset($_POST['work']) ? $_POST['work'] : '';
		$organization = isset($_POST['organization']) ? $_POST['organization'] : '';
		$remarks = isset($_POST['remarks']) ? $_POST['remarks'] : '';
		$senior = isset($_POST['senior']) ? 1 : 0;
		$pensioner = isset($_POST['pensioner']) ? 1 : 0;
		$uct = isset($_POST['uct']) ? 1 : 0;
		$nhts = isset($_POST['nhts']) ? 1 : 0;
		$pwd = isset($_POST['pwd']) ? 1 : 0;
		$fourps = isset($_POST['fourps']) ? 1 : 0;
		$new_voter = isset($_POST['new_voter']) ? 1 : 0;
		$new_affiliation = isset($_POST['new_affiliation']) ? 1 : 0;

		$this->voterObj = new voterModel();
		$res = $this->voterObj->save_voter_profile($voter_sys_id, $fname, $mname, $lname, $ext, $vin, $vno, $precinctno, $clusterno, $purok, $barangay, $birthdate, $sex, $contact, $work, $organization, $senior, $pensioner, $uct, $nhts, $pwd, $fourps, $new_voter, $remarks, $new_affiliation);
		echo $res;
	}

	public function save_image(){
		$voterid = isset($_GET['id']) ? $_GET['id'] : "";

		$voter_model = new voterModel();
		$profile = $voter_model->get_voter_profile($voterid);

		$file = $_FILES['file']['tmp_name'];
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$votername = $profile['firstname'].$profile['middlename'].$profile['lastname'].$profile['suffix'];

		$path = 'public/supporters_image/'.$votername.'.'.$ext;
		$dist = $_SERVER['DOCUMENT_ROOT'].ROOT.'public/supporters_image/'.$votername.'.'.$ext;
		move_uploaded_file($file, $dist);

		echo $voter_model->update_image($path, $voterid);
	}

	public function setVoterRemarks(){
		$voterid = $_POST['voterid'];
		$remarks = $_POST['remarks'];
		$voterObj = new voterModel();
		$res = $voterObj->setVoterRemarks($voterid, $remarks);
		echo $res;
	}
}
?>