
<?php

class wardModel extends model{

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

	public function check_if_supporter($param = array()){
		$year = $this->get_year();
		$query = '';
		
		$position = $param['position'];
		$voterid = $param['voterid'];

		if ($position == 'leader'){
			$query = 'SELECT twl.voter_id
						FROM tbl_ward_leader AS twl
					  	WHERE twl.voter_id = '.$voterid.' AND twl.record_year = '.$year.' AND status = 1';
		}
		elseif ($position == 'member'){
			$query = 'SELECT twm.ward_id
						FROM tbl_ward_member AS twm
					  	WHERE twm.voter_id = '.$voterid.' AND twm.record_year = '.$year.' AND status = 1';
		}

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt->close();
			$this->con->close();
			return true;
		}
		
		$stmt->close();
		$this->con->close();
		return false;
	}

	public function save_ward($param = array()){
		$year = $this->get_year();
		$status = '1';
		$leader_id = $param['leader'];
		$members = $param['members'];
		$barangay = $param['barangay'];

		$stmt = $this->con->prepare("SELECT * FROM tbl_ward_leader WHERE voter_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $leader_id, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare("UPDATE tbl_ward_leader SET status = 1 WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $leader_id, $year);
			$stmt->execute();
		}
		else{
			$stmt = $this->con->prepare("INSERT INTO tbl_ward_leader (voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("ssss", $leader_id, $barangay, $year, $status);
			$stmt->execute();
		}
				
		//Get ward leader's record id
		$wardinfo = $this->get_ward_info(array('voterid' => $leader_id));
		$wardid = $wardinfo['wardid'];

		$db = new database();
		$this->con = $db->connection();
		foreach ($members as $key => $voter) {
			//Check if voter already exist in table ward members
			$stmt = $this->con->prepare("SELECT * FROM tbl_ward_member WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $voter, $year);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($result->num_rows >= 1){
				//Update voter's ward id and status if exist in table ward members
				$stmt = $this->con->prepare("UPDATE tbl_ward_member SET ward_id = ?, status = ? WHERE voter_id = ? AND record_year = ?");
				$stmt->bind_param("ssss", $wardid, $status, $voter, $year);
				$stmt->execute();
			}
			else{
				//Save if voter does not exist in table ward members
				$stmt = $this->con->prepare("INSERT INTO tbl_ward_member (ward_id, voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param("sssss", $wardid, $voter, $barangay, $year, $status);
				$stmt->execute();
			}
			
		}

		$stmt->close();
		$this->con->close();
		return 1;
	}

	public function update_ward($param = array()){
		$year = $this->get_year();
		$status = '1';
		$wardid = $param['wardid'];
		$leader_id = $param['leader'];
		$members = $param['members'];
		$barangay = $param['barangay'];

		//Save ward leader
		$stmt = $this->con->prepare("UPDATE tbl_ward_leader SET voter_id = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $leader_id, $wardid);
		$stmt->execute();
				
		foreach ($members as $key => $voter) {
			//Check if voter already exist in table ward members
			$stmt = $this->con->prepare("SELECT * FROM tbl_ward_member WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $voter, $year);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($result->num_rows >= 1){
				//Update voter's ward id and status if exist in table ward members
				$stmt = $this->con->prepare("UPDATE tbl_ward_member SET ward_id = ?, status = ? WHERE voter_id = ? AND record_year = ?");
				$stmt->bind_param("ssss", $wardid, $status, $voter, $year);
				$stmt->execute();
			}
			else{
				//Save if voter does not exist in table ward members
				$stmt = $this->con->prepare("INSERT INTO tbl_ward_member (ward_id, voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param("sssss", $wardid, $voter, $barangay, $year, $status);
				$stmt->execute();
			}
		}

		$stmt->close();
		$this->con->close();
		return 1;
	}

	public function delete_ward($param = array()){
		$year = $this->get_year();
		$status = '1';
		$wardid = $param['wardid'];

		//Check if ward leader exist
		$stmt = $this->con->prepare("SELECT * FROM tbl_ward_leader WHERE record_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $wardid, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare("UPDATE tbl_ward_leader SET status = 0 WHERE record_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $wardid, $year);
			$stmt->execute();
		}

		//Check if ward members exist
		$stmt = $this->con->prepare("SELECT * FROM tbl_ward_member WHERE ward_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $wardid, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $this->con->prepare("UPDATE tbl_ward_member SET status = 0 WHERE ward_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $wardid, $year);
			$stmt->execute();
		}

		$stmt->close();
		$this->con->close();
		return 1;
	}

	public function get_wardleader($param = array()){
		$year = $this->get_year();
		$id = $param['id'];
		
		$query = 'SELECT tvl.firstname AS firstname, tvl.middlename AS middlename, tvl.lastname AS lastname, tvl.suffix AS suffix
					FROM tbl_ward_member AS twm
					INNER JOIN tbl_ward_leader AS twl ON twl.record_id = twm.ward_id
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twl.voter_id
					WHERE twm.voter_id = '.$id.' AND twm.record_year = '.$year.' AND twm.status = 1';
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		
		$leader_info = array('firstname' => $data['firstname'],
								'middlename' => $data['middlename'],
								'lastname' => $data['lastname'],
								'suffix' => $data['suffix']);
				
		$stmt->close();
		$this->con->close();
		return $leader_info;
	}

	public function get_wardmembers($param = array()){
		$year = $this->get_year();
		$wardid = $param['wardid'];
		
		$query = 'SELECT twm.voter_id,  tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix
					FROM tbl_ward_member AS twm
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twm.voter_id
					WHERE twm.ward_id = '.$wardid.' AND twm.record_year = '.$year.' AND twm.status = 1
					ORDER BY tvl.lastname ASC, tvl.firstname ASC';

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix);
		$ctr=0;
		$members = array();

		while ($stmt->fetch()) {
			$members[$ctr++] = array('id' => $id, 
							'firstname' => utf8_encode($firstname), 
							'middlename' => utf8_encode($middlename),
							'lastname' => utf8_encode($lastname),
							'suffix' => $suffix);
		}
		
		$stmt->close();
		$this->con->close();
		return $members;
	}

	public function get_ward_leaders_list($param = array()){
		$year = $this->get_year();
		$barangay = $param['barangay'];

		$query = 'SELECT twl.record_id, twl.voter_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix 
					FROM tbl_ward_leader AS twl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twl.voter_id
					WHERE twl.barangay_id = '.$barangay.' AND twl.record_year = '.$year.' AND twl.status = 1 GROUP BY twl.voter_id ORDER BY tvl.lastname ASC';
		
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($wardid, $id, $firstname, $middlename, $lastname, $suffix);
		$ctr=0;
		$leaders = array();

		while ($stmt->fetch()) {
			$leaders[$ctr++] = array('wardid' => $wardid,
							'id' => $id, 
							'firstname' => utf8_encode($firstname), 
							'middlename' => utf8_encode($middlename),
							'lastname' => utf8_encode($lastname),
							'suffix' => $suffix);
		}
		$stmt->close();
		$this->con->close();
		return $leaders;
	}

	public function remove_ward_member($param = array()){
		$year = $this->get_year();
		$id = $param['id'];

		$query = 'UPDATE tbl_ward_member SET status = 0 WHERE voter_id = ? AND record_year = ?';

		$stmt = $this->con->prepare($query);
		$stmt->bind_param("ss", $id, $year);
		$stmt->execute();
		
		$stmt->close();
		$this->con->close();
	}

	public function get_ward_info($param = array()){
		$year = $this->get_year();
		$voterid = $param['voterid'];
		
		$query = 'SELECT record_id, voter_id, barangay_id, record_year, status FROM tbl_ward_leader WHERE voter_id = '.$voterid.' AND record_year = '.$year;
		
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		
		$ward_info = array('wardid' => $data['record_id'],
								'leaderid' => $data['voter_id'],
								'barangay' => $data['barangay_id'],
								'year' => $data['record_year'],
								'status' => $data['status']);
				
		$stmt->close();
		$this->con->close();
		return $ward_info;
	}
}
