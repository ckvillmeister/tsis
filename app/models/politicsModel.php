<?php

class politicsModel extends model{

	private $con;
	public $positions = [
		1 => 'Mayor',
		2 => 'Vice-Mayor',
		3 => 'Councilor',
	];

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_year(){
		$settingsObj = new settingsModel();
		$settings = $settingsObj->get_settings();

		foreach ($settings as $key => $value) {
			$data = (object) $value;
			if ($data->name == 'Active Election Year'){
				return $data->desc;
			}
		}
	}

	public function process_candidate($id, $firstname, $middlename, $lastname, $isallied){
		$status = 1;
		$result = 0;

		if ($id == 0){
			$stmt = $this->con->prepare("INSERT INTO tbl_candidates (firstname, middlename, lastname, isallied, status) VALUES (?, ?, ?, ? ,?)");
			$stmt->bind_param("sssss", $firstname, $middlename, $lastname, $isallied, $status);
			$stmt->execute();
			$result = 1;
		}
		else{
			$query_candidate = "SELECT * FROM tbl_candidates WHERE record_id = ".$id;

			if (mysqli_num_rows(mysqli_query($this->con, $query_candidate)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_candidates SET firstname = ?, 
												middlename = ?,
												lastname = ?,
												isallied = ?,
												status = ? WHERE record_id = ?");
				$stmt->bind_param("ssssss", $firstname, $middlename, $lastname, $isallied, $status, $id);
				$stmt->execute();
				$result = 2;
			}
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_candidates($status, $slate = 0){
		$candidates_w_lineup = ($slate) ? $this->get_candidates_with_lineup() : [];

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, firstname, middlename, lastname, isallied, status FROM tbl_candidates WHERE status = ".$status." ORDER BY lastname ASC, firstname ASC");
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $isallied, $status);
		$candidates = array();

		while ($stmt->fetch()) {
			$found = 0;
			foreach ($candidates_w_lineup as $candidate) {
				if ($candidate == $id){
					$found = 1;
					break;
				}
			}

			if (!$found){
				$candidates[] = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'isallied' => $isallied,
							'status' => $status
						);
			}
			
		}
		$stmt->close();
		$this->con->close();
		return $candidates;
	}

	public function get_candidates_with_lineup(){
		$year = $this->get_year();

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT candidate_id FROM tbl_candidates_per_party WHERE status = 1 AND year = ".$year);
		$stmt->execute();
		$stmt->bind_result($candidate_id);
		$candidates = array();

		while ($stmt->fetch()) {
			$candidates[] = $candidate_id;
		}
		$stmt->close();
		$this->con->close();
		return $candidates;
	}

	public function get_candidate_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, firstname, middlename, lastname, isallied, status FROM tbl_candidates WHERE record_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $isallied, $status);
		$candidateinfo = array();

		while ($stmt->fetch()) {
			$candidateinfo = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'isallied' => $isallied,
							'status' => $status
						);
		}
		//$stmt->close();
		//$this->con->close();
		return $candidateinfo;
	}

	public function toggle_candidate($id, $status){
		
		$stmt = $this->con->prepare("UPDATE tbl_candidates SET status = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_party_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, code, name, color, record_year, isallied, status FROM tbl_party WHERE record_id = ".$id);
		$stmt->execute();
		$stmt->bind_result($id, $code, $name, $color, $year, $isallied, $status);
		$party = null;

		while ($stmt->fetch()) {
			$party = array('id' => $id, 
							'code' => $code, 
							'name' => $name,
							'color' => $color,
							'year' => $year,
							'isallied' => $isallied,
							'status' => $status,
						);
		}
		$stmt->close();
		$this->con->close();
		return $party;
	}

	public function store_party($id, $code, $name){
		$year = $this->get_year();
		$result = 0;

		if ($id == 0){
			$stmt = $this->con->prepare("INSERT INTO tbl_party (code, name, record_year, status) VALUES (?, ?, ?, 1)");
			$stmt->bind_param("sss", $code, $name, $year);
			$stmt->execute();
			$result = 1;
		}
		else{
			$stmt = $this->con->prepare("UPDATE tbl_party SET code = ?, 
												name = ? WHERE record_id = ?");
			$stmt->bind_param("sss", $code, $name, $id);
			$stmt->execute();
			$result = 2;
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_parties($status){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, code, name, color, record_year, status FROM tbl_party WHERE status = ".$status);
		$stmt->execute();
		$stmt->bind_result($id, $code, $name, $color, $year, $status);
		$parties = array();

		while ($stmt->fetch()) {
			$parties[] = array('id' => $id, 
							'code' => $code, 
							'name' => $name,
							'color' => $color,
							'year' => $year,
							'status' => $status,
						);
		}
		$stmt->close();
		$this->con->close();
		return $parties;
	}

	public function toggle_party($id, $status){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("UPDATE tbl_party SET status = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function allied_party(){
		$year = $this->get_year();

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, code, name, color, record_year, isallied, status FROM tbl_party WHERE isallied = 1 LIMIT 1");
		$stmt->execute();
		$stmt->bind_result($id, $code, $name, $color, $year, $isallied, $status);
		$party = null;

		while ($stmt->fetch()) {
			$party = array('id' => $id, 
							'code' => $code, 
							'name' => $name,
							'color' => $color,
							'year' => $year,
							'isallied' => $isallied,
							'status' => $status
						);
		}

		return $party;
	}

	public function get_slate_members($partyid, $status){
		$year = $this->get_year();

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, party_id, candidate_id, position, year, status FROM tbl_candidates_per_party WHERE party_id = ".$partyid." AND status = ".$status." AND year =".$year." ORDER BY position ASC");

		$stmt->execute();
		$stmt->bind_result($id, $party, $candidate, $position, $year, $status);
		$members = array();

		while ($stmt->fetch()) {
			$members[] = array('id' => $id, 
							'candidate' => $this->get_candidate_info($candidate), 
							'position' => $this->positions[$position], 
							'year' => $year,
							'status' => $status,
						);
		}
		$stmt->close();
		$this->con->close();
		return $members;
	}

	public function party_add_member($id, $politician, $position){
		$year = $this->get_year();
		$result = 0;

		$stmt = $this->con->prepare("INSERT INTO tbl_candidates_per_party (party_id, candidate_id, position, year, status) VALUES (?, ?, ?, ?, 1)");
		$stmt->bind_param("ssss", $id, $politician, $position, $year);
		$stmt->execute();
		$result = 1;

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function party_remove_member($memberid){
		$result = 0;

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("UPDATE tbl_candidates_per_party SET status = 0 WHERE record_id = ?");
		$stmt->bind_param("s", $memberid);
		$stmt->execute();
		$result = 1;

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function set_party_allied($id, $status){
		$result = 0;

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("UPDATE tbl_party SET isallied =  ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_election_results($id, $status){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, candidate_id, barangay, number_of_votes, year, status FROM tbl_election_results WHERE candidate_id = ".$id." AND status = ".$status);
		$stmt->execute();
		$stmt->bind_result($id, $candidateid, $barangay, $votes, $year, $status);
		$candidates = array();

		while ($stmt->fetch()) {
			$settings_model = new settingsModel();
			$barangay_name = $settings_model->get_barangay_info($barangay);

			$candidates[] = array('id' => $id, 
							'candidateid' => $candidateid, 
							'position' => ($this->get_position($candidateid, $year)) ? $this->positions[$this->get_position($candidateid, $year)] : '',
							'barangay' => $barangay_name['name'],
							'votes' => $votes,
							'year' => $year,
							'status' => $status,
						);
		}
		$stmt->close();
		$this->con->close();
		return $candidates;
	}

	public function get_position($candidateid, $year){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT position FROM tbl_candidates_per_party WHERE candidate_id = ".$candidateid." AND year = ".$year);
		$stmt->execute();
		$stmt->bind_result($position);
		$post = null;

		while ($stmt->fetch()) {
			$post = $position;
		}
		// $stmt->close();
		// $this->con->close();
		return $post;
	}

	public function process_vote_record($record_id, $candidateid, $position, $level, $party, $barangay, $votes, $year){
		$status = 1;
		$result = 0;

		if ($record_id == 0){
			$query = "SELECT * FROM tbl_election_results WHERE candidate_id = ".$candidateid." AND barangay = ".$barangay." AND year = ".$year;

			if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
				$result = 3;
			}
			else{
				$stmt = $this->con->prepare("INSERT INTO tbl_election_results (candidate_id, barangay, number_of_votes, year, status) VALUES (? ,?, ?, ?, ?)");
				$stmt->bind_param("sssss", $candidateid, $barangay, $votes, $year, $status);
				$stmt->execute();
				$stmt->close();
				$result = 1;
			}
		}
		else{
			$query = "SELECT * FROM tbl_election_results WHERE record_id = ".$record_id;

			if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_election_results SET candidate_id = ?, 
												barangay = ?,
												number_of_votes = ?,
												year = ?,
												status = ? WHERE record_id = ?");
				$stmt->bind_param("ssssss", $candidateid, $barangay, $votes, $year, $status, $record_id);
				$stmt->execute();
				$stmt->close();
				$result = 2;
			}
		}

		
		$this->con->close();
		return $result;
	}

	public function get_voter_record_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, candidate_id, barangay, number_of_votes, year, status FROM tbl_election_results WHERE record_id = ".$id);
		$stmt->execute();
		$stmt->bind_result($id, $candidateid, $barangay, $votes, $year, $status);
		$voterecordinfo = array();

		while ($stmt->fetch()) {

			$voterecordinfo = array('id' => $id, 
							'candidateid' => $candidateid, 
							'barangay' => $barangay,
							'votes' => $votes,
							'year' => $year,
							'status' => $status
						);
		}
		$stmt->close();
		$this->con->close();
		return $voterecordinfo;
	}

	public function toggle_election_result($id, $status){
		
		$stmt = $this->con->prepare("UPDATE tbl_election_results SET status = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}

}