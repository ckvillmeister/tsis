<?php

class reportModel extends model{

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
			if ($data->name == 'Active Election Year'){
				return $data->desc;
			}
		}
	}

	public function get_ward_list($param = array()){
		$year = $this->get_year();
		$barangay = $param['barangay'];
		
		$query = 'SELECT twl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, 
					tvl.precinct_no, tvl.purok_no, tvl.cluster_no, tvl.image_url
					FROM tbl_ward_leader AS twl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twl.voter_id
					WHERE twl.barangay_id = ? AND twl.record_year = ? AND twl.status = 1';

		$stmt = $this->con->prepare($query);
		$stmt->bind_param('ss', $barangay, $year);
		$stmt->execute();
		$stmt->bind_result($wardid, $firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno, $imgurl);
		$ward = array();
		$wardlist = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$ward['leader'] = array('wardid' => $wardid, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'clusterno' => $clusterno,
							'imgurl' => $imgurl);
			$ward['members'] = $this->get_ward_members($wardid, $year);
			$wardlist[$ctr++] = $ward;		
		}
		
		$stmt->close();
		$this->con->close();
		return $wardlist;
	}

	public function get_ward_members($wardid, $year){
		$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, 
					tvl.precinct_no, tvl.purok_no, tvl.cluster_no
					FROM tbl_ward_member AS twm
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twm.voter_id
					WHERE twm.ward_id = ? AND twm.record_year = ? ORDER BY tvl.lastname ASC';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('ss', $wardid, $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno);
		$member = array();
		$ward_members = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$member[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'clusterno' => $clusterno);
			$ward_members[$wardid] = $member;

		}

		return $ward_members;
	}

	public function get_election_result($year){
		$query = 'SELECT tc.firstname, tc.middlename, tc.lastname, SUM(number_of_votes) AS total_votes, ter.position
					FROM tbl_election_results ter
					INNER JOIN tbl_candidates tc ON tc.record_id = ter.candidate_id
					WHERE ter.year = ?
					GROUP BY ter.candidate_id
					ORDER BY ter.level ASC, total_votes DESC';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $votes, $position);
		$candidates = array();
		$ctr = 0;

		$total_voters = $this->total_voters($year);
		$total_supporters = $this->total_supporters($year);

		while ($stmt->fetch()) {
			$candidates[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'position' => $position,
							'total_voters' => $total_voters,
							'total_supporters' => $total_supporters,
							'votes' => $votes);

		}

		return $candidates;
	}

	public function total_supporters($year){
		$leaders = 0;
		$members = 0;
		
		$db = new database();
		$connection = $db->connection();
		$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_leader WHERE record_year = ?';
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$leaders = $data['total_supporters'];

		$db = new database();
		$connection = $db->connection();
		$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_member WHERE record_year = ?';
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$members = $data['total_supporters'];

		return $leaders + $members;
	}

	public function total_voters($year){
		$total_voters = 0;
		
		$db = new database();
		$connection = $db->connection();
		$query = 'SELECT COUNT(*) AS total_voters FROM tbl_voters_list WHERE record_year = ?';
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$total_voters = $data['total_voters'];

		return $total_voters;
	}

	public function get_supporters_list($type, $barangay){
		$query = '';
		$year = $this->get_year();
		
		if ($type == 1){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name
								FROM tbl_barangay_leader tbl
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = tbl.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = tbl.barangay_id
								WHERE tbl.record_year = '.$year;

			if ($barangay){
				$query .= ' AND tbl.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY tbl.barangay_id ASC';
		}
		elseif ($type == 2){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name
								FROM tbl_purok_leader tpl
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = tpl.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = tpl.barangay_id
								WHERE tpl.record_year = '.$year;

			if ($barangay){
				$query .= ' AND tpl.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY tpl.barangay_id ASC, tvl.purok_no ASC';
		}
		if ($type == 3){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name
								FROM tbl_ward_leader twl
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = twl.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = twl.barangay_id
								WHERE twl.record_year = '.$year;

			if ($barangay){
				$query .= ' AND twl.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY twl.barangay_id ASC, tvl.purok_no ASC, tvl.lastname ASC, tvl.firstname ASC, tvl.middlename';
		}
		if ($type == 4){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name
								FROM tbl_ward_member twm
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = twm.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = twm.barangay_id
								WHERE twm.record_year = '.$year;

			if ($barangay){
				$query .= ' AND twm.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY twm.barangay_id ASC, tvl.purok_no ASC, tvl.lastname ASC, tvl.firstname ASC, tvl.middlename';
		}

		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $clusterno, $purokno, $barangay);
		$supporters = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$supporters[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'clusterno' => $clusterno,
							'purokno' => $purokno,
							'barangay' => $barangay);
		}
		
		$stmt->close();
		$this->con->close();
		return $supporters;
	}

	public function get_positions(){
	
		$db = new database();
		$connection = $db->connection();
		$query = 'SELECT position FROM tbl_election_results GROUP BY position ORDER BY level';
		$stmt = $connection->prepare($query);
		$stmt->execute();
		$stmt->bind_result($position);
		$positions = array();
		
		while ($stmt->fetch()) {
			$positions[] = array('position' => $position);
		}

		$stmt->close();
		$this->con->close();

		return $positions;
	}

	public function get_comparison($position){
		$year = $this->get_year();
		$query = 'SELECT ter.candidate_id, tc.firstname, tc.middlename, tc.lastname, SUM(ter.number_of_votes) AS total_votes
					FROM tbl_election_results ter 
					INNER JOIN tbl_candidates tc ON tc.record_id = ter.candidate_id
					WHERE ter.position = ? 
					AND ter.year = ?
					GROUP BY ter.candidate_id
					ORDER BY total_votes DESC';
		
		$db = new database();
		$conn = $db->connection();
		$stmt = $conn->prepare($query);
		$stmt->bind_param('ss', $position, $year);
		$stmt->execute();
		$stmt->bind_result($candidate_id, $firstname, $middlename, $lastname, $total_votes);
		$candidates = array();

		while ($stmt->fetch()) {
			

			$candidates[] = array('firstname' => $firstname, 
									'middlename' => $middlename,
									'lastname' => $lastname,
									'votes' => $this->get_votes_per_candidate($candidate_id));

		}

		$stmt->close();
		return $candidates;
	}

	public function get_votes_per_candidate($candidate_id){
		$year = $this->get_year();
		$qryVotesPerBarangay = 'SELECT ter.number_of_votes, tb.barangay_name 
								FROM tbl_election_results ter 
								INNER JOIN tbl_barangay tb ON tb.record_id = ter.barangay
								WHERE ter.candidate_id = ? 
								AND ter.year = ? 
								ORDER BY ter.barangay ASC';

		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($qryVotesPerBarangay);
		$stmt->bind_param('ss', $candidate_id, $year);
		$stmt->execute();
		$stmt->bind_result($acquired_votes, $barangay);
		$votes_acquired = array();

		while ($stmt->fetch()) {
			$votes_acquired[$barangay] = $acquired_votes;
		}

		$stmt->close();
		return $votes_acquired;
	}

	public function retrieve_precincts(){
		$year = $this->get_year();
		$qryPrecincts = 'SELECT precinct_no 
								FROM tbl_voters_list
								WHERE record_year = ?
								GROUP BY precinct_no';

		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($qryPrecincts);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$stmt->bind_result($precinctno);
		$precincts = array();

		while ($stmt->fetch()) {
			$precincts[] = $precinctno;
		}

		$stmt->close();
		return $precincts;
	}

	public function get_search_list($barangay, $purok, $precinct, $name){
		$year = $this->get_year();
		$query = 'SELECT firstname, middlename, lastname, suffix, voters_no, 
					precinct_no, purok_no, cluster_no
					FROM tbl_voters_list
					WHERE record_year = ?'; 

		if ($barangay){
			$query .= ' AND barangay = '.$barangay;
		}

		if ($purok){
			$query .= ' AND purok_no = '.$purok;
		}

		if ($precinct){
			$query .= ' AND precinct_no = "'.$precinct.'"';
		}

		if ($name){
			$query .= ' AND (firstname LIKE "%'.$name.'%" OR middlename LIKE "%'.$name.'%" OR lastname LIKE "%'.$name.'%")';
		}

		$query .= ' ORDER BY lastname ASC';

		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno);
		$member = array();
		$search_list = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$search_list[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'clusterno' => $clusterno);

		}

		$stmt->close();
		return $search_list;
	}

	public function get_total_supporters(){
		$settings_model = new settingsModel();
		$barangays = $settings_model->get_barangays(1);

		$year = $this->get_year();
		$sup_per_brgy = array();
		$db = new database();
		$connection = $db->connection();

		foreach ($barangays as $key => $barangay) {

			$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_leader WHERE record_year = ? AND barangay_id = ?';
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$leaders = ($data['total_supporters']) ? $data['total_supporters'] : 0 ;
			
			$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_member WHERE record_year = ? AND barangay_id = ?';
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$members = ($data['total_supporters']) ? $data['total_supporters'] : 0 ;
			
			$sup_per_brgy[] = $leaders + $members;
		}

		$stmt->close();
		return $sup_per_brgy;
	}

	public function get_total_voters(){
		$settings_model = new settingsModel();
		$barangays = $settings_model->get_barangays(1);

		$year = $this->get_year();
		$voters_per_brgy = array();
		$db = new database();
		$connection = $db->connection();

		foreach ($barangays as $key => $barangay) {

			$query = 'SELECT COUNT(*) AS total FROM tbl_voters_list WHERE record_year = ? AND barangay = ?';
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$total = ($data['total']) ? $data['total'] : 0 ;
			
			$voters_per_brgy[] = $total;
		}

		$stmt->close();
		return $voters_per_brgy;
	}
	
}

?>