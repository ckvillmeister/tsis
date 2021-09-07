<?php

class candidatesModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
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

	public function get_candidates($status){
		$stmt = $this->con->prepare("SELECT record_id, firstname, middlename, lastname, isallied, status FROM tbl_candidates WHERE status = ".$status);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $isallied, $status);
		$candidates = array();

		while ($stmt->fetch()) {
			$candidates[] = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'isallied' => $isallied,
							'status' => $status
						);
		}
		$stmt->close();
		$this->con->close();
		return $candidates;
	}

	public function get_candidate_info($id){
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
		$stmt->close();
		$this->con->close();
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

	public function get_election_results($id, $status){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, candidate_id, position, level, party, barangay, number_of_votes, year, status FROM tbl_election_results WHERE candidate_id = ".$id." AND status = ".$status);
		$stmt->execute();
		$stmt->bind_result($id, $candidateid, $position, $level, $party, $barangay, $votes, $year, $status);
		$candidates = array();

		while ($stmt->fetch()) {
			$settings_model = new settingsModel();
			$barangay_name = $settings_model->get_barangay_info($barangay);

			$candidates[] = array('id' => $id, 
							'candidateid' => $candidateid, 
							'position' => $position,
							'level' => $level,
							'party' => $party,
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

	public function process_vote_record($record_id, $candidateid, $position, $level, $party, $barangay, $votes, $year){
		$status = 1;
		$result = 0;

		if ($record_id == 0){
			$query = "SELECT * FROM tbl_election_results WHERE candidate_id = ".$candidateid." AND barangay = ".$barangay." AND year = ".$year;

			if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
				$result = 3;
			}
			else{
				$stmt = $this->con->prepare("INSERT INTO tbl_election_results (candidate_id, position, level, party, barangay, number_of_votes, year, status) VALUES (?, ?, ?, ? ,?, ?, ?, ?)");
				$stmt->bind_param("ssssssss", $candidateid, $position, $level, $party, $barangay, $votes, $year, $status);
				$stmt->execute();
				$stmt->close();
				$result = 1;
			}
		}
		else{
			$query = "SELECT * FROM tbl_election_results WHERE record_id = ".$record_id;

			if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_election_results SET candidate_id = ?, 
												position = ?,
												level = ?,
												party = ?,
												barangay = ?,
												number_of_votes = ?,
												year = ?,
												status = ? WHERE record_id = ?");
				$stmt->bind_param("sssssssss", $candidateid, $position, $level, $party, $barangay, $votes, $year, $status, $record_id);
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
		$stmt = $this->con->prepare("SELECT record_id, candidate_id, position, level, party, barangay, number_of_votes, year, status FROM tbl_election_results WHERE record_id = ".$id);
		$stmt->execute();
		$stmt->bind_result($id, $candidateid, $position, $level, $party, $barangay, $votes, $year, $status);
		$voterecordinfo = array();

		while ($stmt->fetch()) {

			$voterecordinfo = array('id' => $id, 
							'candidateid' => $candidateid, 
							'position' => $position,
							'level' => $level,
							'party' => $party,
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