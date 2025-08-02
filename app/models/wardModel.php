
<?php

class wardModel extends model{

	public function __construct(){
		
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


		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt->close();
			$con->close();
			return true;
		}
		
		$stmt->close();
		$con->close();
		return false;
	}

	public function check_if_sk_supporter($param = array()){
		$year = $this->get_year();
		$query = '';
		
		$voterid = $param['voterid'];

		$query = 'SELECT ts.voter_id
						FROM tbl_sk AS ts
					  	WHERE ts.voter_id = '.$voterid.' AND ts.record_year = '.$year.' AND ts.status = 1';

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt->close();
			$con->close();
			return true;
		}
		
		$stmt->close();
		$con->close();
		return false;
	}

	public function save_ward($param = array()){
		$year = $this->get_year();
		$status = '1';
		$leader_id = $param['leader'];
		$members = $param['members'];
		$barangay = $param['barangay'];

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare("SELECT * FROM tbl_ward_leader WHERE voter_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $leader_id, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $con->prepare("UPDATE tbl_ward_leader SET status = 1 WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $leader_id, $year);
			$stmt->execute();
		}
		else{
			$stmt = $con->prepare("INSERT INTO tbl_ward_leader (voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?)");
			$stmt->bind_param("ssss", $leader_id, $barangay, $year, $status);
			$stmt->execute();
		}
				
		//Get ward leader's record id
		$wardinfo = $this->get_ward_info(array('voterid' => $leader_id));
		$wardid = $wardinfo['wardid'];

		foreach ($members as $key => $voter) {
			//Check if voter already exist in table ward members
			$stmt = $con->prepare("SELECT * FROM tbl_ward_member WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $voter, $year);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($result->num_rows >= 1){
				//Update voter's ward id and status if exist in table ward members
				$stmt = $con->prepare("UPDATE tbl_ward_member SET ward_id = ?, status = ? WHERE voter_id = ? AND record_year = ?");
				$stmt->bind_param("ssss", $wardid, $status, $voter, $year);
				$stmt->execute();
			}
			else{
				//Save if voter does not exist in table ward members
				$stmt = $con->prepare("INSERT INTO tbl_ward_member (ward_id, voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param("sssss", $wardid, $voter, $barangay, $year, $status);
				$stmt->execute();
			}
			
		}

		$stmt->close();
		$con->close();
		return 1;
	}

	public function update_ward($param = array()){
		$year = $this->get_year();
		$status = '1';
		$wardid = $param['wardid'];
		$leader_id = $param['leader'];
		$members = $param['members'];
		$barangay = $param['barangay'];

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare("UPDATE tbl_ward_leader SET voter_id = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $leader_id, $wardid);
		$stmt->execute();
				
		foreach ($members as $key => $voter) {
			//Check if voter already exist in table ward members
			$stmt = $con->prepare("SELECT * FROM tbl_ward_member WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $voter, $year);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($result->num_rows >= 1){
				//Update voter's ward id and status if exist in table ward members
				$stmt = $con->prepare("UPDATE tbl_ward_member SET ward_id = ?, status = ? WHERE voter_id = ? AND record_year = ?");
				$stmt->bind_param("ssss", $wardid, $status, $voter, $year);
				$stmt->execute();
			}
			else{
				//Save if voter does not exist in table ward members
				$stmt = $con->prepare("INSERT INTO tbl_ward_member (ward_id, voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?, ?)");
				$stmt->bind_param("sssss", $wardid, $voter, $barangay, $year, $status);
				$stmt->execute();
			}
		}

		$stmt->close();
		$con->close();
		return 1;
	}

	public function save_sk($param = array()){
		$year = $this->get_year();
		$status = '1';
		$members = $param['members'];
		$barangay = $param['barangay'];

		$db = new database();
		$con = $db->connection();
				
		foreach ($members as $key => $voter) {
			//Check if voter already exist in table ward members
			$stmt = $con->prepare("SELECT * FROM tbl_sk WHERE voter_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $voter, $year);
			$stmt->execute();
			$result = $stmt->get_result();
			
			if ($result->num_rows >= 1){
				//Update voter's ward id and status if exist in table ward members
				$stmt = $con->prepare("UPDATE tbl_sk SET status = ? WHERE voter_id = ? AND record_year = ?");
				$stmt->bind_param("sss", $status, $voter, $year);
				$stmt->execute();
			}
			else{
				//Save if voter does not exist in table ward members
				$stmt = $con->prepare("INSERT INTO tbl_sk (voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?)");
				$stmt->bind_param("ssss", $voter, $barangay, $year, $status);
				$stmt->execute();
			}
		}

		$stmt->close();
		$con->close();
		return 1;
	}

	public function save_special_ops($barangay, $candidates, $voters, $party){
		$year = $this->get_year();
		$status = '1';

		$db = new database();
		$con = $db->connection();
				
		foreach ($candidates as $candidate) {
			foreach ($voters as $voter) {
				//Check if voter already exist in table ward members
				$stmt = $con->prepare("SELECT * FROM tbl_special_ops WHERE party_id = ? AND candidate_id = ? AND voter_id = ? AND record_year = ?");
				$stmt->bind_param("ssss", $party, $candidate, $voter, $year);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if ($result->num_rows >= 1){
					//Update voter's ward id and status if exist in table ward members
					$stmt = $con->prepare("UPDATE tbl_special_ops SET status = ? WHERE party_id = ? AND candidate_id = ? AND voter_id = ? AND record_year = ?");
					$stmt->bind_param("sssss", $party, $status, $candidate, $voter, $year);
					$stmt->execute();
				}
				else{
					//Save if voter does not exist in table ward members
					$stmt = $con->prepare("INSERT INTO tbl_special_ops (party_id, candidate_id, voter_id, barangay_id, record_year, status) VALUES (?, ?, ?, ?, ?, ?)");
					$stmt->bind_param("ssssss", $party, $candidate, $voter, $barangay, $year, $status);
					$stmt->execute();
				}
			}
		}

		$stmt->close();
		$con->close();
		return 1;
	}

	public function delete_ward($param = array()){
		$year = $this->get_year();
		$status = '1';
		$wardid = $param['wardid'];

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare("SELECT * FROM tbl_ward_leader WHERE record_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $wardid, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $con->prepare("UPDATE tbl_ward_leader SET status = 0 WHERE record_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $wardid, $year);
			$stmt->execute();
		}

		//Check if ward members exist
		$stmt = $con->prepare("SELECT * FROM tbl_ward_member WHERE ward_id = ? AND record_year = ?");
		$stmt->bind_param("ss", $wardid, $year);
		$stmt->execute();
		$result = $stmt->get_result();
		
		if ($result->num_rows >= 1){
			$stmt = $con->prepare("UPDATE tbl_ward_member SET status = 0 WHERE ward_id = ? AND record_year = ?");
			$stmt->bind_param("ss", $wardid, $year);
			$stmt->execute();
		}

		$stmt->close();
		$con->close();
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

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		
		$leader_info = array('firstname' => $data['firstname'],
								'middlename' => $data['middlename'],
								'lastname' => $data['lastname'],
								'suffix' => $data['suffix']);
				
		$stmt->close();
		$con->close();
		return $leader_info;
	}

	public function get_wardmembers($param = array()){
		$year = $this->get_year();
		$wardid = $param['wardid'];
		
		$query = 'SELECT twm.voter_id,  tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.image_url
					FROM tbl_ward_member AS twm
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twm.voter_id
					WHERE twm.ward_id = '.$wardid.' AND twm.record_year = '.$year.' AND twm.status = 1
					ORDER BY tvl.lastname ASC, tvl.firstname ASC';

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $imgurl);
		$ctr=0;
		$members = array();

		while ($stmt->fetch()) {
			$members[$ctr++] = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'imgurl' => $imgurl);
		}
		
		$stmt->close();
		$con->close();
		return $members;
	}

	public function get_sk_list($param = array()){
		$year = $this->get_year();
		$barangayid = $param['barangayid'];
		
		$query = 'SELECT ts.voter_id,  tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.precinct_no, tvl.image_url
					FROM tbl_sk AS ts
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = ts.voter_id
					WHERE ts.barangay_id = '.$barangayid.' AND ts.record_year = '.$year.' AND ts.status = 1
					ORDER BY tvl.lastname ASC, tvl.firstname ASC';

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $precinct_no, $imgurl);
		$ctr=0;
		$members = array();

		while ($stmt->fetch()) {
			$members[$ctr++] = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'precinct_no' => $precinct_no,
							'imgurl' => $imgurl);
		}
		
		$stmt->close();
		$con->close();
		return $members;
	}

	public function get_special_supporters($party, $barangay){
		$year = $this->get_year();
		
		$query = 'SELECT tvl.record_id,  tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.precinct_no, tvl.image_url,
					tc.record_id, tc.firstname, tc.middlename, tc.lastname
					FROM tbl_special_ops AS tso
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = tso.voter_id
					INNER JOIN tbl_candidates tc ON tc.record_id = tso.candidate_id
					WHERE tso.barangay_id = '.$barangay.' AND tso.party_id = '.$party.' AND tso.record_year = '.$year.' AND tso.status = 1
					ORDER BY tso.candidate_id ASC, tvl.lastname ASC, tvl.firstname ASC';

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $precinct_no, $imgurl, $cid, $cfirstname, $cmiddlename, $clastname);
		$ctr=0;
		$supporters = array();

		while ($stmt->fetch()) {
			$supporters[$ctr++] = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'precinct_no' => $precinct_no,
							'imgurl' => $imgurl,
							'cid' => $cid, 
							'cfirstname' => $cfirstname, 
							'cmiddlename' => $cmiddlename,
							'clastname' => $clastname);
		}
		
		$stmt->close();
		$con->close();
		return $supporters;
	}

	public function get_ward_leaders_list($param = array()){
		$year = $this->get_year();
		$barangay = $param['barangay'];

		$query = 'SELECT twl.record_id, twl.voter_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix 
					FROM tbl_ward_leader AS twl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twl.voter_id
					WHERE twl.barangay_id = '.$barangay.' AND twl.record_year = '.$year.' AND twl.status = 1 GROUP BY twl.voter_id ORDER BY tvl.lastname ASC';

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($wardid, $id, $firstname, $middlename, $lastname, $suffix);
		$ctr=0;
		$leaders = array();

		while ($stmt->fetch()) {
			$leaders[$ctr++] = array('wardid' => $wardid,
							'id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix);
		}
		$stmt->close();
		$con->close();
		return $leaders;
	}

	public function remove_ward_member($param = array()){
		$year = $this->get_year();
		$id = $param['id'];

		$query = 'UPDATE tbl_ward_member SET status = 0 WHERE voter_id = ? AND record_year = ?';

		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->bind_param("ss", $id, $year);
		$stmt->execute();
		
		$stmt->close();
		$con->close();
	}

	public function remove_sk_supporter($param = array()){
		$year = $this->get_year();
		$id = $param['id'];
		$brgy = $param['brgy'];

		if ($id){
			$query = 'UPDATE tbl_sk SET status = 0 WHERE voter_id = ? AND record_year = ?';

			$db = new database();
			$con = $db->connection();
			$stmt = $con->prepare($query);
			$stmt->bind_param("ss", $id, $year);
			$stmt->execute();
			
			$stmt->close();
			$con->close();
		}
		else{
			$query = 'UPDATE tbl_sk SET status = 0 WHERE barangay_id = ? AND record_year = ?';

			$db = new database();
			$con = $db->connection();
			$stmt = $con->prepare($query);
			$stmt->bind_param("ss", $brgy, $year);
			$stmt->execute();
			
			$stmt->close();
			$con->close();
		}

		return 1;
		
	}

	public function remove_special_supporter($party, $supporter, $candidate){
		$year = $this->get_year();
		$status = '1';

		$db = new database();
		$con = $db->connection();
				
		$stmt = $con->prepare("UPDATE tbl_special_ops SET status = 0 WHERE party_id = ? AND candidate_id = ? AND voter_id = ? AND record_year = ?");
		$stmt->bind_param("ssss", $party, $candidate, $supporter, $year);
		$stmt->execute();

		$stmt->close();
		$con->close();
		return 1;
	}

	public function get_ward_info($param = array()){
		$year = $this->get_year();
		$voterid = $param['voterid'];
		
		$query = 'SELECT record_id, voter_id, barangay_id, record_year, status FROM tbl_ward_leader WHERE voter_id = '.$voterid.' AND record_year = '.$year;
		
		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		
		$ward_info = array('wardid' => $data['record_id'],
								'leaderid' => $data['voter_id'],
								'barangay' => $data['barangay_id'],
								'year' => $data['record_year'],
								'status' => $data['status']);
				
		$stmt->close();
		$con->close();
		return $ward_info;
	}

	public function retrieve_matched_supporter_names($supporter_name){
		$year = $this->get_year();
		$supporter_name = '%'.$supporter_name.'%';

		$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tb.barangay_name, twl.record_id, tvl.record_id, tvl.image_url
					FROM tbl_voters_list AS tvl
					INNER JOIN tbl_ward_leader AS twl ON twl.voter_id = tvl.record_id
					INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
					WHERE (tvl.firstname LIKE ? OR tvl.middlename LIKE ? OR tvl.lastname LIKE ? OR 
					CONCAT(TRIM(tvl.firstname), " ", TRIM(tvl.lastname)) LIKE ?) AND tvl.record_year = ? AND twl.status = 1
					ORDER BY tvl.lastname ASC, tvl.firstname ASC, tvl.middlename ASC';
		
		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->bind_param("sssss", $supporter_name, $supporter_name, $supporter_name, $supporter_name, $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $barangay, $wardid, $voter_sys_id, $imgurl);
		$ctr=0;
		$result = array();

		while ($stmt->fetch()) {
			$result[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'barangay' => $barangay,
							'rank' => 'Leader',
							'wardid' => $wardid,
							'voter_sys_id' => $voter_sys_id,
							'imgurl' => $imgurl);
		}

		$stmt->close();

		$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tb.barangay_name, twm.ward_id, tvl.record_id, tvl.image_url
					FROM tbl_voters_list AS tvl
					INNER JOIN tbl_ward_member AS twm ON twm.voter_id = tvl.record_id
					INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
					WHERE (tvl.firstname LIKE ? OR tvl.middlename LIKE ? OR tvl.lastname LIKE ? OR 
					CONCAT(TRIM(tvl.firstname), " ", TRIM(tvl.lastname)) LIKE ?) AND tvl.record_year = ?  AND twm.status = 1
					ORDER BY tb.record_id ASC, tvl.lastname ASC, tvl.firstname ASC, tvl.middlename ASC';

		$db = new database();
		$con = $db->connection();			
		$stmt2 = $con->prepare($query);
		$stmt2->bind_param("sssss", $supporter_name, $supporter_name, $supporter_name, $supporter_name, $year);
		$stmt2->execute();
		$stmt2->bind_result($firstname, $middlename, $lastname, $suffix, $barangay, $wardid, $voter_sys_id, $imgurl);

		while ($stmt2->fetch()) {
			$result[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'barangay' => $barangay,
							'rank' => 'Member',
							'wardid' => $wardid,
							'voter_sys_id' => $voter_sys_id,
							'imgurl' => $imgurl);
		}
		$stmt2->close();

		$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tb.barangay_name, tvl.record_id, tvl.image_url
					FROM tbl_voters_list AS tvl
					INNER JOIN tbl_special_ops AS tso ON tso.voter_id = tvl.record_id
					INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
					WHERE (tvl.firstname LIKE ? OR tvl.middlename LIKE ? OR tvl.lastname LIKE ? OR 
					CONCAT(TRIM(tvl.firstname), " ", TRIM(tvl.lastname)) LIKE ?) AND tvl.record_year = ?  AND tso.status = 1
					GROUP BY tvl.record_id
					ORDER BY tb.record_id ASC, tvl.lastname ASC, tvl.firstname ASC, tvl.middlename ASC';

		$db = new database();
		$con = $db->connection();			
		$stmt3 = $con->prepare($query);
		$stmt3->bind_param("sssss", $supporter_name, $supporter_name, $supporter_name, $supporter_name, $year);
		$stmt3->execute();
		$stmt3->bind_result($firstname, $middlename, $lastname, $suffix, $barangay, $voter_sys_id, $imgurl);

		while ($stmt3->fetch()) {
			$result[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'barangay' => $barangay,
							'rank' => 'Special Ops',
							'wardid' => null,
							'voter_sys_id' => $voter_sys_id,
							'imgurl' => $imgurl);
		}
		$stmt3->close();

		$con->close();
		return $result;
	}

	public function get_leader($wardid){
		$year = $this->get_year();
		$query = 'SELECT  tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tb.barangay_name, twl.record_id, tvl.purok_no, tvl.image_url
					FROM tbl_voters_list AS tvl
					INNER JOIN tbl_ward_leader AS twl ON twl.voter_id = tvl.record_id
					INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
					WHERE twl.record_id = ? AND tvl.record_year = ?';
		
		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare($query);
		$stmt->bind_param("ss", $wardid, $year);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		
		$leader = array('firstname' => $data['firstname'], 
							'middlename' => $data['middlename'],
							'lastname' => $data['lastname'],
							'suffix' => $data['suffix'],
							'barangay' => $data['barangay_name'],
							'wardid' =>$data['record_id'],
							'purok' =>$data['purok_no'],
							'imgurl' => $data['image_url']);
		
				
		$stmt->close();
		$con->close();
		return $leader;
	}

	function getAllLeaders($year){
		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare("SELECT record_id, voter_id, barangay_id FROM tbl_ward_leader WHERE status = 1 AND record_year = ?");
		$stmt->bind_param("s", $year);
		$stmt->execute();
		$stmt->bind_result($id, $voterid, $barangayid);
		$leaders = [];

		while ($stmt->fetch()) {
			$leaders[] = ['id' => $id, 'voterid' => $voterid, 'barangayid' => $barangayid];
		}
		
		$stmt->close();
		$con->close();
		return $leaders;
	}

	function getAllMembers($year){
		$db = new database();
		$con = $db->connection();
		$stmt = $con->prepare("SELECT record_id, ward_id, voter_id, barangay_id FROM tbl_ward_member WHERE status = 1 AND record_year = ?");
		$stmt->bind_param("s", $year);
		$stmt->execute();
		$stmt->bind_result($id, $wardid, $voterid, $barangayid);
		$members = [];

		while ($stmt->fetch()) {
			$members[] = ['id' => $id, 'wardid' => $wardid, 'voterid' => $voterid, 'barangayid' => $barangayid];
		}
		
		$stmt->close();
		$con->close();
		return $members;
	}
}
