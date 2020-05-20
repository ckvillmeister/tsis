<?php

class leaderController extends controller{

	public function barangay_leader(){
		$this->view()->render('main.php', array('content' => 'leader/barangay_leader/index.php'));
	}

	public function purok_leader(){
		$settingsObj = new settingsModel();
		$barangay = $settingsObj->get_barangay();
		$this->view()->render('main.php', array('content' => 'leader/purok_leader/index.php', 'barangay' => $barangay));
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