<?php

class leaderController extends controller{

	public function barangay_leader(){
		$this->view()->render('main.php', array('content' => 'leader/barangay_leader/index.php'));
	}

	public function purok_leader(){
		$this->view()->render('main.php', array('content' => 'leader/purok_leader/index.php'));
	}

	public function get_barangay_leaders(){
		$leaderObj = new leaderModel();
		$leaders = $leaderObj->get_barangay_leaders();
		$this->view()->render('leader/barangay_leader/barangay_leader_list.php', array('leaders' => $leaders));
	}
}
?>