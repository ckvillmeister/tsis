
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
		$sk = isset($param['sk']) ? $param['sk'] : 0;

		$query = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, 
							tvl.vin, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, 
							tb.barangay_name, tvl.birthdate, tvl.gender, tvl.is_new_voter
							FROM tbl_voters_list AS tvl
							INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
							WHERE tvl.status = 1 AND tvl.record_year = '.$year;

		if (count($param) >= 1){
			if ($barangay = $param['brgy']){
				$query .= ' AND tvl.barangay = '.$barangay;
			}
		}

		if ($sk){
			$query .= ' AND tvl.is_sk = 1';
		}
		else{
			$query .= ' AND (is_sk IS NULL OR is_sk = 0)';
		}

		$query .= ' GROUP BY tvl.record_id';
		
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $vin, $votersno, $precinctno, $clusterno, $purokno, $barangay, $birthdate, $gender, $new_voter);
		$ctr=0;
		$voters = array();
		while ($stmt->fetch()) {
			$voters[$ctr++] = array('id' => $id, 
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
							'new_voter' => $new_voter);
		}
		$stmt->close();
		$this->con->close();
		return $voters;
	}

	public function get_voter_profile($voterid){
		$year = $this->get_year();

		$query = 'SELECT tvl.record_id, tvl.firstname, tvl.middlename, tvl.lastname, tvl.suffix, 
							tvl.vin, tvl.voters_no, tvl.precinct_no, tvl.cluster_no, tvl.purok_no, 
							tb.barangay_name, tvl.birthdate, tvl.gender, tvl.barangay, tvl.image_url, 
							tvl.contact_number, tvl.current_work, tvl.organization, tvl.is_social_pensioner, 
							tvl.is_uct_member, tvl.is_nhts, tvl.is_pwd, tvl.is_4pcs, tvl.is_senior_citizen, tvl.is_new_voter, tvl.remarks, tvl.is_new_affiliation
							FROM tbl_voters_list AS tvl
							INNER JOIN tbl_barangay AS tb ON tb.record_id = tvl.barangay
							WHERE tvl.record_id = '.$voterid;

		
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $firstname, $middlename, $lastname, $suffix, $vin, $votersno, $precinctno, $clusterno, $purokno, $barangay, $birthdate, $gender, $barangayid, $imgurl, $contact, $work, $org, $pensioner, $uct, $nhts, $pwd, $fourps, $senior, $new_voter, $remarks, $new_affiliation);
		$profile = array();

		while ($stmt->fetch()) {
			$profile = array('id' => $id, 
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
							'imgurl' => $imgurl,
							'contact' => $contact,
							'work' => $work,
							'org' => $org,
							'remarks' => $remarks,
							'pensioner' => $pensioner,
							'uct' => $uct,
							'nhts' => $nhts,
							'pwd' => $pwd,
							'fourps' => $fourps,
							'senior' => $senior,
							'new_voter' => $new_voter,
							'new_affiliation' => $new_affiliation
						);
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

	public function save_voter_profile($id, $fname, $mname, $lname, $ext, $vin, $vno, $precinctno, $clusterno, $purok, $barangay, $birthdate, $sex, $contact, $work, $organization, $senior, $pensioner, $uct, $nhts, $pwd, $fourps, $new_voter, $remarks, $new_affiliation){

		$status = 1;
		$result = 0;
		$year = $this->get_year();

		if ($id == 0){
			$stmt = $this->con->prepare("INSERT INTO tbl_voters_list (firstname, middlename, lastname, suffix, vin, voters_no, precinct_no, cluster_no, purok_no, barangay, birthdate, gender, contact_number, current_work, organization, remarks, is_senior_citizen, is_social_pensioner, is_uct_member, is_nhts, is_pwd, is_4pcs, is_new_voter, is_new_affiliation, record_year, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 1)");
			$stmt->bind_param("sssssssssssssssssssssssss", $fname, $mname, $lname, $ext, $vin, $vno, $precinctno, $clusterno, $purok, $barangay, $birthdate, $sex, $contact, $work, $organization, $remarks, $senior, $pensioner, $uct, $nhts, $pwd, $fourps, $new_voter, $new_affiliation, $year);
			$stmt->execute();
			$result = 1;
		}
		else{
			$query_role = "SELECT * FROM tbl_voters_list WHERE record_id = ".$id;

			if (mysqli_num_rows(mysqli_query($this->con, $query_role)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_voters_list 
													SET 
													firstname = ?, 
													middlename = ? ,
													lastname = ?, 
													suffix = ? ,
													vin = ?, 
													voters_no = ? ,
													precinct_no = ?, 
													cluster_no = ? ,
													purok_no = ?, 
													barangay = ? ,
													birthdate = ?, 
													gender = ? ,
													contact_number = ?, 
													current_work = ?, 
													organization = ?, 
													remarks = ?,
													is_senior_citizen = ?,
													is_social_pensioner = ?, 
													is_uct_member = ?, 
													is_nhts = ?, 
													is_pwd = ?, 
													is_4pcs = ?,
													is_new_voter=?,
													is_new_affiliation=?,
													record_year = ?
													WHERE record_id = ?");
				$stmt->bind_param("ssssssssssssssssssssssssss", $fname, $mname, $lname, $ext, $vin, $vno, $precinctno, $clusterno, $purok, $barangay, $birthdate, $sex, $contact, $work, $organization, $remarks, $senior, $pensioner, $uct, $nhts, $pwd, $fourps, $new_voter, $new_affiliation, $year, $id);
				$stmt->execute();
				$result = 2;
			}
		}

		$stmt->close();
		$this->con->close();
		return $result;
		
	}

	public function setVoterRemarks($voterid, $remarks){
		$query = '';

		if (ucwords($remarks) == 'New Affiliation'){
			$query = 'UPDATE tbl_voters_list SET is_new_affiliation = 1 WHERE record_id = '.$voterid;
		}
		else{
			$query = 'UPDATE tbl_voters_list SET remarks = "'.$remarks.'" WHERE record_id = '.$voterid;
		}
		
		$db = new database();	
		$this->con = $db->connection();
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		
		$stmt->close();
		$this->con->close();
		return 1;
	}
}
