
<?php

class voterModel extends model{

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

	public function get_voters_list($param = array()){
		$settingsObj = new settingsModel();
		$settings = $settingsObj->get_settings();
		$year = $this->get_year();

		$query = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, 
							tvl.vin, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, 
							tb.barangay_name, tvl.birthdate, tvl.gender 
							FROM tbl_voters_list AS tvl
							INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
							WHERE record_year = '.$year;

		if (count($param) >= 1){
			$barangay = $param['barangay'];
			$query .= ' AND tvl.barangay = '.$barangay;
		}

		$query .= ' GROUP BY tvl.record_id';

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $vin, $votersno, $precinctno, $clusterno, $purokno, $barangay, $birthdate, $gender);
		$ctr=0;
		$voters = array();
		while ($stmt->fetch()) {
			$voters[$ctr++] = array('id' => $id, 
							'firstname' => utf8_encode($firstname), 
							'middlename' => utf8_encode($middlename),
							'lastname' => utf8_encode($lastname),
							'suffix' => $suffix,
							'vin' => $vin,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'clusterno' => $clusterno,
							'purokno' => $purokno,
							'barangay' => $barangay,
							'birthdate' => $birthdate,
							'gender' => $gender);
		}
		$stmt->close();
		$this->con->close();
		return $voters;
	}

	public function get_voter_profile($voterid){
		$year = $this->get_year();

		$query = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, 
							tvl.vin, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, 
							tb.barangay_name, tvl.birthdate, tvl.gender, tvl.barangay, tvl.image_url
							FROM tbl_voters_list AS tvl
							INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
							WHERE tvl.record_id = '.$voterid;


		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $vin, $votersno, $precinctno, $clusterno, $purokno, $barangay, $birthdate, $gender, $barangayid, $imgurl);
		$profile = array();

		while ($stmt->fetch()) {
			$profile[] = array('id' => $id, 
							'firstname' => $firstname, 
							'middlename' => $middlename,
							'lastname' => $lastname,
							'suffix' => $suffix,
							'vin' => $vin,
							'votersno' => $votersno,
							'precinctno' => $precinctno,
							'clusterno' => $clusterno,
							'purokno' => $purokno,
							'barangay' => $barangay,
							'birthdate' => $birthdate,
							'gender' => $gender,
							'barangayid' => $barangayid,
							'imgurl' => $imgurl);
		}
		$stmt->close();
		$this->con->close();
		return $profile;
	}

	public function update_image($path, $voterid){
		$query = 'UPDATE tbl_voters_list SET image_url = ? WHERE record_id = ?';

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare($query);
		$stmt->bind_param("ss", $path, $voterid);
		$stmt->execute();
		
		$stmt->close();
		$this->con->close();
		return 1;
	}
}
