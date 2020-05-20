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
			$leader_info = $this->get_leader_info($id, '', $year, 'barangay');
			$leader_list[$ctr++] = array('barangay_id' => $id, 
										'barangay_name' => $barangay_name,
										'voter_id' => $leader_info['id'],
										'fullname' => $leader_info['fullname']);
		}
		$stmt->close();
		$this->con->close();
		return $leader_list;
	}

	public function set_barangay_leader($param = array()){
		$year = $this->get_year();
		$voters_id = $param['voters_id'];
		$barangay_id = $param['barangay_id'];
		$status = 1;

		$stmt = $this->con->prepare("SELECT * FROM tbl_barangay_leader WHERE barangay_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $barangay_id, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare("UPDATE tbl_barangay_leader SET voter_id = ? WHERE barangay_id = ? AND record_year = ?");
			$stmt->bind_param("sss", $voters_id, $barangay_id, $year);
			$stmt->execute();
		}
		else{
			$stmt = $this->con->prepare("INSERT INTO tbl_barangay_leader (voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("ssss", $voters_id, $barangay_id, $year, $status);
			$stmt->execute();
		}
		
		$stmt->close();
		$this->con->close();
		return 1;		
	}

	public function get_purok_leaders($params = array()){
		$year = $this->get_year();
		$barangay_id = $params['barangay_id'];
		$query = 'SELECT purok_no, voter_id FROM tbl_purok_leader WHERE barangay_id = ?';
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("s", $barangay_id);
		$stmt->execute();
		$stmt->bind_result($purok_no, $voter_id);
		$leader_list = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$leader_info = $this->get_leader_info($barangay_id, $purok_no, $year, 'purok');
			$leader_list[$ctr++] = array('purok' => $purok_no, 
										'voter_id' => $leader_info['id'],
										'fullname' => $leader_info['fullname']);
		}

		$stmt->close();
		$this->con->close();
		return $leader_list;
	}

	public function set_purok_leader($param = array()){
		$year = $this->get_year();
		$voters_id = $param['voters_id'];
		$barangay_id = $param['barangay_id'];
		$purok_no = $param['purok_no'];
		$status = 1;

		$stmt = $this->con->prepare("SELECT * FROM tbl_purok_leader WHERE barangay_id = ? AND purok_no = ? AND record_year = ?");
		$stmt->bind_param("sss", $barangay_id, $purok_no, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare("UPDATE tbl_purok_leader SET voter_id = ? WHERE barangay_id = ? AND purok_no = ? AND record_year = ?");
			$stmt->bind_param("ssss", $voters_id, $barangay_id, $purok_no, $year);
			$stmt->execute();
		}
		else{
			$stmt = $this->con->prepare("INSERT INTO tbl_purok_leader (voter_id, barangay_id, purok_no, record_year, status) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sssss", $voters_id, $barangay_id, $purok_no, $year, $status);
			$stmt->execute();
		}
		
		$stmt->close();
		$this->con->close();
		return 1;		
	}
	
	public function get_leader_info($barangay_id, $purok_no, $year, $leader_type){
		$db = new database();
		$connection = $db->connection();
		$query_voter = '';
		$st;

		if ($leader_type=='barangay'){
			$query_voter = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix	
					FROM tbl_barangay_leader AS tbl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = tbl.voter_id
					WHERE tbl.record_year = ? AND tbl.barangay_id = ?';
					$st = $connection->prepare($query_voter);
					$st->bind_param("ss", $year, $barangay_id);
		}
		elseif ($leader_type=='purok'){
			$query_voter = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix	
					FROM tbl_purok_leader AS tpl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = tpl.voter_id
					WHERE tpl.record_year = ? AND tpl.barangay_id = ? AND tpl.purok_no = ?
					ORDER BY tpl.purok_no ASC';
					$st = $connection->prepare($query_voter);
					$st->bind_param("sss", $year, $barangay_id, $purok_no);
		}
		
		$st->execute();
		$result = $st->get_result();
		$info = array();

		if ($result->num_rows >= 1){
			$st;

			if ($leader_type=='barangay'){
				$query_voter = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix	
					FROM tbl_barangay_leader AS tbl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = tbl.voter_id
					WHERE tbl.record_year = ? AND tbl.barangay_id = ?';
				$st = $connection->prepare($query_voter);
				$st->bind_param("ss", $year, $barangay_id);
				$st->execute();
			}
			elseif ($leader_type=='purok'){
				$query_voter = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tpl.purok_no	
						FROM tbl_purok_leader AS tpl
						INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = tpl.voter_id
						WHERE tpl.record_year = ? AND tpl.barangay_id = ? AND tpl.purok_no = ?
						ORDER BY tpl.purok_no ASC';
				$st = $connection->prepare($query_voter);
				$st->bind_param("sss", $year, $barangay_id, $purok_no);
				$st->execute();
			}
			
			$data = $st->get_result()->fetch_assoc();
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