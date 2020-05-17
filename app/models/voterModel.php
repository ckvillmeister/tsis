
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
			if ($data->name == 'Active Year'){
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

}
