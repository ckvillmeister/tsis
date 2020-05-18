<?php

class leaderModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_year(){
		$settingsObj = new settingsModel();
		$settings = $settingsObj->get_settings();

		foreach ($settings as $key => $value) {
			$data = (object) $value;
			if ($data->name == 'Active Year'){
				return $data->desc;
			}
		}
	}

	public function get_barangay_leaders(){
		$year = $this->get_year();
		$query = 'SELECT record_id, barangay_name FROM tbl_barangay';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $barangay_name);
		$leader_list = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$leader_info = $this->get_leader_info($id, $year);
			$leader_list[$ctr++] = array('barangay_id' => $id, 
										'barangay_name' => $barangay_name,
										'voter_id' => $leader_info['id'],
										'fullname' => $leader_info['fullname']);
		}
		$stmt->close();
		$this->con->close();
		return $leader_list;
	}

	public function get_leader_info($barangay_id, $year){
		$db = new database();
		$connection = $db->connection();
		$query_voter = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix	
					FROM tbl_barangay_leader AS tbl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = tbl.voter_id
					WHERE tbl.record_year = ? AND tbl.barangay_id = ?';
		$stmt = $connection->prepare($query_voter);
		$stmt->bind_param("ss", $year, $id);
		$stmt->execute();
		$result = $stmt->get_result();
		$info = array();

		if ($result->num_rows >= 1){
			$data = $stmt->get_result()->fetch_assoc();
			$fullname = $data['firstname'].' '.$data['middlename'].' '.$data['lastname'].' '.$data['suffix'];
		
			$info = array('id' => $data['record_id'], 'fullname' => $fullname);			
		}
		else{
			$info = array('id' => '', 'fullname' => '');	
		}
		return $info;
	}
}

?>