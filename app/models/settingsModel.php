
<?php

class settingsModel extends model{

	private $con;

	public function __construct(){
		//$db = new database();
		//$this->con = $db->connection();
	}

	public function get_system_name(){

		$arr_settings = array();
  		$settings = $this->get_settings();
  		
  		foreach ($settings as $key => $setting) {
    		$arr_settings[$setting['name']] = $setting['desc'];
  		}
		
		return $arr_settings['System Name'];
	}

	public function get_settings(){

		$query = 'SELECT record_id, setting_name, setting_desc FROM tbl_sys_settings';

		$db = new database();
		$this->con = $db->connection();
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

	public function get_barangays($status){

		$query = 'SELECT record_id, barangay_name, status FROM tbl_barangay WHERE status = '.$status.' ORDER BY record_id';

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare($query);
		$stmt->execute();
		$stmt->bind_result($id, $name, $status);
		$ctr=0;
		$barangay = array();

		while ($stmt->fetch()) {
			$barangay[$ctr++] = array('id' => $id, 
							'name' => $name,
							'status' => $status);
		}
		$stmt->close();
		$this->con->close();
		return $barangay;
	}

	public function save_settings($name, $year){
		$db = new database();
		$this->con = $db->connection();

		$stmt = $this->con->prepare("UPDATE tbl_sys_settings SET setting_desc = ? WHERE setting_name = 'System Name'");
		$stmt->bind_param("s", $name);
		$stmt->execute();

		$stmt = $this->con->prepare("UPDATE tbl_sys_settings SET setting_desc = ? WHERE setting_name = 'Active Election Year'");
		$stmt->bind_param("s", $year);
		$stmt->execute();

		$stmt->close();
		$this->con->close();
		return 1;
	}

	public function process_barangay($id, $barangay){
		$status = 1;
		$result = 0;

		$db = new database();
		$this->con = $db->connection();

		if ($id == 0){
			$stmt = $this->con->prepare("INSERT INTO tbl_barangay (barangay_name, status) VALUES (?, ?)");
			$stmt->bind_param("ss", $barangay, $status);
			$stmt->execute();
			$result = 1;
		}
		else{
			$query_brgy = "SELECT * FROM tbl_barangay WHERE record_id = ".$id;

			if (mysqli_num_rows(mysqli_query($this->con, $query_brgy)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_barangay SET barangay_name = ? WHERE record_id = ?");
				$stmt->bind_param("ss", $barangay, $id);
				$stmt->execute();
				$result = 2;
			}
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_barangay_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, barangay_name, status FROM tbl_barangay WHERE record_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $name, $status);
		$barangayinfo = array();

		while ($stmt->fetch()) {
			$barangayinfo = array('id' => $id, 
							'name' => $name, 
							'status' => $status);
		}
		$stmt->close();
		$this->con->close();
		return $barangayinfo;
	}

	public function toggle_barangay($id, $status){
		
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("UPDATE tbl_barangay SET status = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_sys_info($sys_name){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, setting_name, setting_desc FROM tbl_sys_settings WHERE setting_name = '".$sys_name."'");;
		$stmt->execute();
		$stmt->bind_result($id, $name, $desc);
		$imageinfo = array();

		while ($stmt->fetch()) {
			$imageinfo = array('id' => $id, 
							'name' => $name, 
							'desc' => $desc);
		}
		$stmt->close();
		$this->con->close();
		return $imageinfo;
	}

	public function update_image($path, $sys_name){
		$db = new database();
		$this->con = $db->connection();

		$query = 'SELECT * FROM tbl_sys_settings WHERE setting_name = "'.$sys_name.'"';
		
		if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
			$query = 'UPDATE tbl_sys_settings SET setting_desc = "'.$path.'" WHERE setting_name = "'.$sys_name.'"';
			$stmt = $this->con->prepare($query);
			$stmt->execute();
	
			$stmt->close();
			$this->con->close();
			return 1;
		}
		else{
			$query = 'INSERT INTO tbl_sys_settings (setting_name, setting_desc) VALUES ("'.$sys_name.'", "'.$path.'")';
			$stmt = $this->con->prepare($query);
			$stmt->execute();
	
			$stmt->close();
			$this->con->close();
			return 1;
		}
	}

}