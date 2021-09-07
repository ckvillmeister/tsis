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

			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'voters')){
				$this->view()->render('voter/index.php', array('system_name' => $system_name));
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

	public function get_voters_list(){
		//$content = file_get_contents(PATH_VIEW.'/voter/table.php');
		//echo $content;
		$this->voterObj = new voterModel();
		$voters = $this->voterObj->get_voters_list();
		$this->view()->render('voter/list.php', array('voters' => $voters));
	}

	public function save_voter_profile(){
		$voter_sys_id = isset($_POST['id']) ? $_POST['id'] : '';
		$fname = isset($_POST['fname']) ? $_POST['fname'] : '';
		$mname = isset($_POST['mname']) ? $_POST['mname'] : '';
		$lname = isset($_POST['lname']) ? $_POST['lname'] : '';
		$ext = isset($_POST['ext']) ? $_POST['ext'] : '';
		$barangay = isset($_POST['barangay']) ? $_POST['barangay'] : '';
		$purok = isset($_POST['purok']) ? $_POST['purok'] : '';
		$sex = isset($_POST['sex']) ? $_POST['sex'] : '';
		$vin = isset($_POST['vin']) ? $_POST['vin'] : '';
		$vno = isset($_POST['vno']) ? $_POST['vno'] : '';
		$precinctno = isset($_POST['precinctno']) ? $_POST['precinctno'] : '';
		$clusterno = isset($_POST['clusterno']) ? $_POST['clusterno'] : '';
	}

	public function save_image(){
		$voterid = isset($_GET['id']) ? $_GET['id'] : "";

		$voter_model = new voterModel();
		$profile = $voter_model->get_voter_profile($voterid);

		$file = $_FILES['file']['tmp_name'];
		$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
		$votername = $profile[0]['firstname'].$profile[0]['middlename'].$profile[0]['lastname'].$profile[0]['suffix'];

		$path = 'public/supporters_image/'.$votername.'.'.$ext;
		$dist = $_SERVER['DOCUMENT_ROOT'].ROOT.'public/supporters_image/'.$votername.'.'.$ext;
		move_uploaded_file($file, $dist);

		echo $voter_model->update_image($path, $voterid);
	}
}
?>