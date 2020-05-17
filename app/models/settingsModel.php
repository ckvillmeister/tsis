
<?php

class settingsModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function get_settings(){

		$query = 'SELECT record_id, setting_name, setting_desc FROM tbl_sys_settings';

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $name, $desc);
		$ctr=0;
		while ($stmt->fetch()) {
			$setting[$ctr++] = array('id' => $id, 
							'name' => $name, 
							'desc' => $desc);
		}
		$stmt->close();
		$this->con->close();
		return $setting;
	}

	public function get_barangay(){

		$query = 'SELECT record_id, barangay_name FROM tbl_barangay';

		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $name);
		$ctr=0;
		while ($stmt->fetch()) {
			$barangay[$ctr++] = array('id' => $id, 
							'name' => $name);
		}
		$stmt->close();
		$this->con->close();
		return $barangay;
	}

}