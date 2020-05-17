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
			if ($data->name == 'Active Year'){
				return $data->desc;
			}
		}
	}

	public function get_ward_list($param = array()){
		$year = $this->get_year();
		$barangay = $param['barangay'];
		
		$query = 'SELECT twl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, tvl.voters_no, 
					tvl.precinct_no, tvl.purok_no, tvl.cluster_no
					FROM tbl_ward_leader AS twl
					INNER JOIN tbl_voters_list AS tvl ON tvl.record_id = twl.voter_id
					WHERE twl.barangay_id = ? AND twl.record_year = ? AND twl.status = 1';

		$stmt = $this->con->prepare($query);
		$stmt->bind_param('ss', $barangay, $year);
		$stmt->execute();
		$stmt->bind_result($wardid, $firstname, $middlename, $lastname, $suffix, $votersno, $precinctno, $purokno, $clusterno);
		$ward = array();
		$wardlist = array();
		$ctr = 0;

		while ($stmt->fetch()) {
			$ward['leader'] = array('wardid' => $wardid, 
							'firstname' => utf8_encode($firstname), 
							'middlename' => utf8_encode($middlename),
							'lastname' => utf8_encode($lastname),
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'clusterno' => $clusterno);
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
			$member[$ctr++] = array('firstname' => utf8_encode($firstname), 
							'middlename' => utf8_encode($middlename),
							'lastname' => utf8_encode($lastname),
							'suffix' => $suffix,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'purokno' => $purokno,
							'clusterno' => $clusterno);
			$ward_members[$wardid] = $member;
		}

		return $ward_members;
	}
	
}

?>