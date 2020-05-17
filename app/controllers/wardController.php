<?php

class wardController extends controller{

	public function index(){
		$settingsObj = new settingsModel();
		$barangay = $settingsObj->get_barangay();
		$this->view()->render('main.php', array('content' => 'ward/index.php', 'barangay' => $barangay));
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
}
?>