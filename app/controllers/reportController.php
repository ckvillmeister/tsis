<?php

class reportController extends controller{

	public function ward_list(){
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
			
			if ($accessrole_model->check_access($role, 'wardlist')){
				$this->view()->render('report/ward_list/index.php', array('barangay' => $barangay, 'system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function election_result(){
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
			
			if ($accessrole_model->check_access($role, 'electionresults')){
				$this->view()->render('report/election_result/index.php', array('system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function comparison(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settingsObj = new settingsModel();
			$system_name = $settingsObj->get_system_name();

			$accessrole_model = new accessroleModel();
			$accessroles = $accessrole_model->get_access_roles(1);
			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];
			
			if ($accessrole_model->check_access($role, 'comparison')){
				$reportObj = new reportModel();
				$positions = $reportObj->get_positions();
				$this->view()->render('report/comparison/index.php', array('system_name' => $system_name, 'positions' => $positions));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function supporters(){
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
			
			if ($accessrole_model->check_access($role, 'supporters')){
				$this->view()->render('report/supporters/index.php', array('barangay' => $barangay, 'system_name' => $system_name));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function search(){
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
			
			if ($accessrole_model->check_access($role, 'search')){
				$reportObj = new reportModel();
				$precincts = $reportObj->retrieve_precincts();
				$this->view()->render('report/search/index.php', array('barangay' => $barangay, 'system_name' => $system_name, 'precincts' => $precincts));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function summary(){
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

   			$report_obj = new reportModel();
   			$summary = $report_obj->retrieve_summary($report_obj->get_year());
			
			if ($accessrole_model->check_access($role, 'summary')){
				$this->view()->render('report/summary/index.php', array('barangay' => $barangay, 
																			'system_name' => $system_name, 
																			'year' => $report_obj->get_year(),
																			'summary' => $summary));
			}
			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}

	public function get_ward_list(){
		$barangay = $_POST['barangay'];
		$reportObj = new reportModel();
		$wardlist = $reportObj->get_ward_list(array('barangay' => $barangay));
		$this->view()->render('report/ward_list/wardlist.php', array('wardlist' => $wardlist));
	}

	public function get_election_result(){
		$year = $_POST['year'];
		$reportObj = new reportModel();
		$results = $reportObj->get_election_result($year);
		$this->view()->render('report/election_result/result.php', array('results' =>$results));
	}

	public function get_comparison(){
		$position = $_POST['position'];

		$settingsObj = new settingsModel();
		$barangay = $settingsObj->get_barangays(1);

		$reportObj = new reportModel();
		$comparison = $reportObj->get_comparison($position);
		$this->view()->render('report/comparison/comparison.php', array('comparison' => $comparison, 'barangay' => $barangay));
	}

	public function get_supporters_list(){
		$type = $_POST['type'];
		$barangay = $_POST['barangay'];

		$reportObj = new reportModel();
		$supporters = $reportObj->get_supporters_list($type, $barangay);
		$this->view()->render('report/supporters/supporterslist.php', array('supporters' => $supporters));
	}

	public function get_search_list(){
		$barangay = $_POST['barangay'];
		$purok = $_POST['purok'];
		$precinct = $_POST['precinct'];
		$name = $_POST['name'];
		$age = $_POST['age'];

		$reportObj = new reportModel();
		$searchlist = $reportObj->get_search_list($barangay, $purok, $precinct, $name, $age);
		$this->view()->render('report/search/searchlist.php', array('searchlist' => $searchlist));
	}

}
?>