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
		$sort = $param['sort'];
		$filter = $param['filter'];
		
		$query = 'SELECT twl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, 
					tvl.precinct_no, tvl.purok_no, tvl.cluster_no, tvl.image_url, tvl.is_new_voter, tvl.remarks, tvl.is_new_affiliation, twl.voter_id
					FROM tbl_ward_leader AS twl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twl.voter_id
					WHERE twl.barangay_id = ? AND twl.record_year = ? AND twl.status = 1';

		if ($filter){
			$query .= ' AND tvl.purok_no = '.$filter;
		}

		if ($sort){
			if ($sort == 'purok'){
				$query .= ' ORDER BY tvl.purok_no ASC,';
			}
			elseif ($sort == 'precinct'){
				$query .= ' ORDER BY tvl.precinct_no ASC,';
			}
			elseif ($sort == 'cluster'){
				$query .= ' ORDER BY tvl.cluster_no ASC,';
			}

			$query .= ' tvl.lastname ASC, tvl.firstname ASC, tvl.middlename ASC';
		}
		else{
			$query .= ' ORDER BY tvl.lastname ASC, tvl.firstname ASC, tvl.middlename ASC';
		}

		

		$stmt = $this->con->prepare($query);
		$stmt->bind_param('ss', $barangay, $year);
		$stmt->execute();
		$stmt->bind_result($wardid, $firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno, $imgurl, $new_voter, $remarks, $new_affiliation, $voterid);
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
							'imgurl' => $imgurl,
							'new_voter' => $new_voter,
							'remarks' => $remarks,
							'voterid' => $voterid,
							'new_affiliation' => $new_affiliation);
			$ward['members'] = $this->get_ward_members($wardid, $year);
			$wardlist[$ctr++] = $ward;		
		}
		
		$stmt->close();
		$this->con->close();
		return $wardlist;
	}

	public function get_ward_members($wardid, $year){
		$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, 
					tvl.precinct_no, tvl.purok_no, tvl.cluster_no, tvl.is_new_voter, tvl.remarks, tvl.is_new_affiliation, twm.voter_id
					FROM tbl_ward_member AS twm
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twm.voter_id
					WHERE twm.ward_id = ? AND twm.record_year = ? AND twm.status = 1 ORDER BY tvl.lastname ASC, tvl.firstname ASC, tvl.middlename ASC';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('ss', $wardid, $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno, $new_voter, $remarks, $new_affiliation, $voterid);
		$member = array();
		$ward_members = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$member[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'votersno' => $votersno,
							'clusterno' => $clusterno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'new_voter' => $new_voter,
							'remarks' => $remarks,
							'voterid' => $voterid,
							'new_affiliation' => $new_affiliation);
			$ward_members[$wardid] = $member;

		}

		return $ward_members;
	}

	public function get_election_result($year){
		$politics = new politicsModel();

		$query = 'SELECT tc.firstname, tc.middlename, tc.lastname, SUM(number_of_votes) AS total_votes, tcpp.position, tcpp.party_id
					FROM tbl_election_results ter
					INNER JOIN tbl_candidates tc ON tc.record_id = ter.candidate_id
					JOIN tbl_candidates_per_party tcpp ON tcpp.candidate_id = ter.candidate_id AND tcpp.year = ?
					WHERE ter.year = ?
					GROUP BY ter.candidate_id
					ORDER BY tcpp.position ASC, total_votes DESC';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('ss', $year, $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $votes, $position, $partyid);
		$candidates = array();
		$ctr = 0;

		$total_voters = $this->total_voters($year);
		$total_supporters = $this->total_supporters($year);
		$allied = $politics->allied_party();

		while ($stmt->fetch()) {
			$candidates[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'position' => $politics->positions[$position],
							'total_voters' => $total_voters,
							'total_supporters' => $total_supporters,
							'partyid' => $partyid,
							'allied' => $allied,
							'votes' => $votes);

		}

		return $candidates;
	}

	public function total_supporters($year){
		$leaders = 0;
		$members = 0;
		
		$db = new database();
		$connection = $db->connection();
		$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_leader WHERE record_year = ? AND status = 1';
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$leaders = $data['total_supporters'];

		$db = new database();
		$connection = $db->connection();
		$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_member WHERE record_year = ? AND status = 1';
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
		$query = 'SELECT COUNT(*) AS total_voters FROM tbl_voters_list WHERE record_year = ? AND status = 1';
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$data = $stmt->get_result()->fetch_assoc();
		$total_voters = $data['total_voters'];

		return $total_voters;
	}

	public function get_supporters_list($type, $barangay, $cluster = 0){
		$query = '';
		$year = $this->get_year();
		
		if ($type == 1){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no,
								tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Barangay Leader"
								FROM tbl_barangay_leader tbl
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = tbl.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = tbl.barangay_id
								WHERE tbl.status = 1 AND tbl.record_year = '.$year;

			if ($barangay){
				$query .= ' AND tbl.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY tbl.barangay_id ASC';
		}
		elseif ($type == 2){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Purok Leader"
								FROM tbl_purok_leader tpl
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = tpl.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = tpl.barangay_id
								WHERE tpl.status = 1 AND tpl.record_year = '.$year;

			if ($barangay){
				$query .= ' AND tpl.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY tpl.barangay_id ASC, tvl.purok_no ASC';
		}
		elseif ($type == 3){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Ward Leader"
								FROM tbl_ward_leader twl
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = twl.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = twl.barangay_id
								WHERE twl.status = 1 AND twl.record_year = '.$year;

			if ($barangay){
				$query .= ' AND twl.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY twl.barangay_id ASC, tvl.purok_no ASC, tvl.lastname ASC, tvl.firstname ASC, tvl.middlename';
		}
		elseif ($type == 4){
			$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, 
								tvl.suffix, tvl.voters_no, tvl.precinct_no, 
								tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Ward Member"
								FROM tbl_ward_member twm
								INNER JOIN tbl_voters_list tvl ON tvl.record_id = twm.voter_id
								INNER JOIN tbl_barangay tb ON tb.record_id = twm.barangay_id
								WHERE twm.status = 1 AND twm.record_year = '.$year;

			if ($barangay){
				$query .= ' AND twm.barangay_id ='.$barangay;
			}

			$query .= ' ORDER BY twm.barangay_id ASC, tvl.purok_no ASC, tvl.lastname ASC, tvl.firstname ASC, tvl.middlename';
		}
		else{
			if ($cluster){
				$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Ward Leader" FROM tbl_ward_leader twl
						JOIN tbl_voters_list tvl ON tvl.record_id = twl.voter_id
						JOIN tbl_barangay tb ON tb.record_id = twl.barangay_id
						WHERE twl.barangay_id = '.$barangay.' AND twl.record_year = '.$year.' AND twl.status = 1 AND tvl.cluster_no = '.$cluster.'
						UNION
						SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Ward Member" FROM tbl_ward_member twm
						JOIN tbl_voters_list tvl ON tvl.record_id = twm.voter_id
						JOIN tbl_barangay tb ON tb.record_id = twm.barangay_id
						WHERE twm.barangay_id = '.$barangay.' AND twm.record_year = '.$year.' AND twm.status = 1 AND tvl.cluster_no = '.$cluster.'
						ORDER BY purok_no ASC, lastname ASC, firstname ASC, middlename ASC';
			}
			else{
				$query = 'SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Ward Leader" FROM tbl_ward_leader twl
						JOIN tbl_voters_list tvl ON tvl.record_id = twl.voter_id
						JOIN tbl_barangay tb ON tb.record_id = twl.barangay_id
						WHERE twl.barangay_id = '.$barangay.' AND twl.record_year = '.$year.' AND twl.status = 1
						UNION
						SELECT tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, tb.barangay_name, "Ward Member" FROM tbl_ward_member twm
						JOIN tbl_voters_list tvl ON tvl.record_id = twm.voter_id
						JOIN tbl_barangay tb ON tb.record_id = twm.barangay_id
						WHERE twm.barangay_id = '.$barangay.' AND twm.record_year = '.$year.' AND twm.status = 1
						ORDER BY purok_no ASC, lastname ASC, firstname ASC, middlename ASC';
			}
		}
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $clusterno, $purokno, $barangay, $rank);
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
							'barangay' => $barangay,
							'rank' => $rank);
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

	public function get_comparison($position, $year){
		$year = ($year) ? $year : $this->get_year();
		$query = 'SELECT ter.candidate_id, tc.firstname, tc.middlename, tc.lastname, SUM(ter.number_of_votes) AS total_votes
					FROM tbl_election_results ter 
					INNER JOIN tbl_candidates tc ON tc.record_id = ter.candidate_id
					JOIN tbl_candidates_per_party tcpp ON tcpp.candidate_id = ter.candidate_id
					WHERE tcpp.position = ?';

		if ($year){
			$query .= ' AND ter.year = '.$year;
		}

		$query .= ' GROUP BY ter.candidate_id ORDER BY total_votes DESC';
		
		$db = new database();
		$conn = $db->connection();
		$stmt = $conn->prepare($query);
		$stmt->bind_param('s', $position);
		$stmt->execute();
		$stmt->bind_result($candidate_id, $firstname, $middlename, $lastname, $total_votes);
		$candidates = array();

		while ($stmt->fetch()) {
			

			$candidates[] = array('firstname' => $firstname, 
									'middlename' => $middlename,
									'lastname' => $lastname,
									'votes' => $this->get_votes_per_candidate($candidate_id, $year));

		}

		$stmt->close();
		return $candidates;
	}

	public function get_votes_per_candidate($candidate_id, $year = 0){
		$year = ($year) ? $year : $this->get_year();
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

	public function get_search_list($barangay, $purok, $cluster, $precinct, $name, $age, $sk = 0){
		$year = $this->get_year();
		$query = 'SELECT firstname, middlename, lastname, suffix, voters_no, 
					precinct_no, purok_no, cluster_no, YEAR(CURDATE()) - YEAR(birthdate) AS age, YEAR(birthdate)
					FROM tbl_voters_list
					WHERE status = 1 AND record_year = ?'; 

		if ($barangay){
			$query .= ' AND barangay = '.$barangay;
		}

		if ($purok){
			$query .= ' AND purok_no = '.$purok;
		}

		if ($cluster){
			$query .= ' AND cluster_no = "'.$cluster.'"';
		}

		if ($precinct){
			$query .= ' AND precinct_no = "'.$precinct.'"';
		}

		if ($name){
			$query .= ' AND (firstname LIKE "%'.$name.'%" OR middlename LIKE "%'.$name.'%" OR lastname LIKE "%'.$name.'%")';
		}

		if ($sk){
			$query .= ' AND is_sk = 1';
		}
		else{
			$query .= ' AND (is_sk IS NULL OR is_sk = 0)';
		}

		$query .= ' ORDER BY lastname ASC';
		
		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($query);
		$stmt->bind_param('s', $year);
		$stmt->execute();
		$stmt->bind_result($firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno, $voters_age, $birthdate);
		$member = array();
		$search_list = array();
		$ctr = 0;

		while ($stmt->fetch()) {

			if ($age){
				if (intval($birthdate)){
					if ($age == 1){
						if ($voters_age >= 15 | $voters_age <= 24){
							$search_list[$ctr++] = array('firstname' => $firstname, 
								'middlename' => $middlename,
								'lastname' => $lastname,
								'suffix' => $suffix,
								'votersno' => $votersno,
								'precinctno' => $precinctno,
								'purokno' => $purokno,
								'clusterno' => $clusterno);
						}
					}
					elseif ($age == 2){
						if ($voters_age >= 25 | $voters_age <= 40){
							$search_list[$ctr++] = array('firstname' => $firstname, 
								'middlename' => $middlename,
								'lastname' => $lastname,
								'suffix' => $suffix,
								'votersno' => $votersno,
								'precinctno' => $precinctno,
								'purokno' => $purokno,
								'clusterno' => $clusterno);
						}
					}
					elseif ($age == 3){
						if ($voters_age >= 41){
							$search_list[$ctr++] = array('firstname' => $firstname, 
								'middlename' => $middlename,
								'lastname' => $lastname,
								'suffix' => $suffix,
								'votersno' => $votersno,
								'precinctno' => $precinctno,
								'purokno' => $purokno,
								'clusterno' => $clusterno);
						}
					}
				}
			}
			else{
				$search_list[$ctr++] = array('firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'clusterno' => $clusterno);
			}
		}

		$stmt->close();
		return $search_list;
	}

	public function get_total_supporters($record_year = null){
		$settings_model = new settingsModel();
		$barangays = $settings_model->get_barangays(1);

		$year = ($record_year) ? $record_year : $this->get_year();
		$sup_per_brgy = array();
		$db = new database();
		$connection = $db->connection();

		foreach ($barangays as $key => $barangay) {

			$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_leader WHERE status = 1 AND record_year = ? AND barangay_id = ?';
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$leaders = ($data['total_supporters']) ? $data['total_supporters'] : 0 ;
			
			$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_member WHERE status = 1 AND record_year = ? AND barangay_id = ?';
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

	public function get_total_voters($record_year = null){
		$settings_model = new settingsModel();
		$barangays = $settings_model->get_barangays(1);

		$year = ($record_year) ? $record_year : $this->get_year();
		$voters_per_brgy = array();
		$db = new database();
		$connection = $db->connection();

		foreach ($barangays as $key => $barangay) {

			$query = 'SELECT COUNT(*) AS total, is_sk FROM tbl_voters_list WHERE record_year = ? AND barangay = ? AND status = 1 AND (is_sk IS NULL OR is_sk = 0)';
			
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

	public function retrieve_summary($year){
		$settings_model = new settingsModel();
		$barangays = $settings_model->get_barangays(1);

		$db = new database();
		$connection = $db->connection();
		$summary = [];

		foreach ($barangays as $key => $barangay) {

			$info['barangay'] = $barangay['name'];

			$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_leader WHERE status = 1 AND record_year = ? AND barangay_id = ?';
			
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$leaders = ($data['total_supporters']) ? $data['total_supporters'] : 0 ;

			$info['leaders'] = $leaders;
			
			$query = 'SELECT COUNT(*) AS total_supporters FROM tbl_ward_member WHERE status = 1 AND record_year = ? AND barangay_id = ?';
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$members = ($data['total_supporters']) ? $data['total_supporters'] : 0 ;

			$info['members'] = $members;

			$query = 'SELECT COUNT(*) AS total_voters FROM tbl_voters_list WHERE status = 1 AND record_year = ? AND barangay = ? AND (is_sk IS NULL OR is_sk = 0)';
			$stmt = $connection->prepare($query);
			$stmt->bind_param('ss', $year, $barangay['id']);
			$stmt->execute();
			$data = $stmt->get_result()->fetch_assoc();
			$total_voters = ($data['total_voters']) ? $data['total_voters'] : 0 ;

			$info['voters'] = $total_voters;
			
			$summary[] = $info;
		}

		$stmt->close();
		return $summary;
	}

	public function get_barangay_clusters($barangay){
		$year = $this->get_year();
		$qryBarangayClusters = 'SELECT cluster_no 
								FROM tbl_voters_list
								WHERE barangay = ? 
								AND record_year = ? 
								GROUP BY cluster_no
								ORDER BY cluster_no ASC';

		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($qryBarangayClusters);
		$stmt->bind_param('ss', $barangay, $year);
		$stmt->execute();
		$stmt->bind_result($cluster);
		$clusters = [];

		while ($stmt->fetch()) {
			$clusters[] = $cluster;
		}

		$stmt->close();
		return $clusters;
	}

	public function get_cluster_precincts($barangay, $cluster){
		$year = $this->get_year();
		$qryBarangayClusters = 'SELECT precinct_no
								FROM tbl_voters_list
								WHERE barangay = ? 
								AND cluster_no = ?
								AND record_year = ? 
								GROUP BY precinct_no
								ORDER BY precinct_no ASC';

		$db = new database();
		$connection = $db->connection();
		$stmt = $connection->prepare($qryBarangayClusters);
		$stmt->bind_param('sss', $barangay, $cluster, $year);
		$stmt->execute();
		$stmt->bind_result($precinct);
		$precincts = [];

		while ($stmt->fetch()) {
			$precincts[] = $precinct;
		}

		$stmt->close();
		return $precincts;
	}
	
}

?>