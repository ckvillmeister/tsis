<?php

class dashboardController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();

			$accessrole_model = new accessroleModel();
 			$accounts_model = new accountsModel();
 			$userinfo = $accounts_model->get_user_info($_SESSION['user_id']);
   			$role = $userinfo['role'];

 			if ($accessrole_model->check_access($role, 'dashboard')){
 				$barangays = $settings_model->get_barangays(1);
				$brgy = array();

				foreach ($barangays as $key => $barangay) {
					$brgy[] = $barangay['name'];
				}

				$report_model = new reportModel();
				$year = $report_model->get_year();
				$total_supporters = $report_model->total_supporters($year);
				$total_supporters_per_brgy = $report_model->get_total_supporters();
				$total_voters_per_brgy = $report_model->get_total_voters();

				$voter_model = new voterModel();
				$total_voters = $voter_model->get_voters_list();
				$total_voters = ($total_voters) ? count($total_voters) : 0;
				
				$this->view()->render('dashboard/index.php', 
										array('system_name' => $system_name,
											'total_voters' => $total_voters,
											'total_supporters' => $total_supporters,
											'total_supporters_per_brgy' => $total_supporters_per_brgy,
											'total_voters_per_brgy' => $total_voters_per_brgy,
											'barangays' => $brgy
									));
 			}
 			else{
				$this->view()->render('error/forbidden.php', array('system_name' => $system_name));
			}
		}
	}
}
?>