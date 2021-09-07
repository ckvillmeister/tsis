<?php

class accountsModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function process_user_account($id, $username, $password, $firstname, $middlename, $lastname, $extension, $role){
		$status = 1;
		$result = 0;
		$password = md5($password);
		$creator = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
		$datetime = date("Y-m-d h:i:s");

		if ($id == 0){
			$stmt = $this->con->prepare("INSERT INTO tbl_users (username, password, firstname, middlename, lastname, suffix, role_type, created_by, date_created, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
			$stmt->bind_param("ssssssssss", $username, $password, $firstname, $middlename, $lastname, $extension, $role, $creator, $datetime, $status);
			$stmt->execute();
			$result = 1;
		}
		else{
			$query_role = "SELECT * FROM tbl_users WHERE record_id = ".$id;

			if (mysqli_num_rows(mysqli_query($this->con, $query_role)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_users SET username = ?,
												firstname = ?,
												middlename = ?,
												lastname = ?,
												suffix = ?,
												role_type = ?,
												updated_by = ?,
												date_updated = ?,
												status = ? WHERE record_id = ?");
				$stmt->bind_param("ssssssssss", $username, $firstname, $middlename, $lastname, $extension, $role, $creator, $datetime, $status, $id);
				$stmt->execute();
				$result = 2;
			}
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_user_accounts($status){
		$db = new database();
		$this->con = $db->connection();
				$stmt = $this->con->prepare("SELECT record_id, username, firstname, middlename, lastname, suffix, role_type, created_by, status FROM tbl_users WHERE status = ".$status);
		$stmt->execute();
		$stmt->bind_result($id, $username, $firstname, $middlename, $lastname, $suffix, $role, $creatorid, $status);
		$users = array();

		while ($stmt->fetch()) {
			$creator;

			if ($creatorid){
				$creator = $this->get_user_info($creatorid);
			}

			$accessrole_model = new accessroleModel();
			$roleinfo = array($accessrole_model->get_access_role_info($role));
			
			$users[] = array('id' => $id,
								'username' => $username, 
								'firstname' => $firstname, 
								'middlename' => $middlename, 
								'lastname' => $lastname, 
								'suffix' => $suffix, 
								'role' => $roleinfo, 
								'creator' => $creator,
								'status' => $status);
		}

		$stmt->close();
		return $users;
	}

	public function get_user_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, username, password, firstname, middlename, lastname, suffix, role_type, created_by FROM tbl_users WHERE record_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $username, $password, $firstname, $middlename, $lastname, $suffix, $role, $creator);
		$user_info = array();

		while ($stmt->fetch()) {
			$user_info = array('id' => $id,
								'username' => $username, 
								'password' => $password, 
								'firstname' => $firstname, 
								'middlename' => $middlename, 
								'lastname' => $lastname, 
								'suffix' => $suffix, 
								'role' => $role, 
								'creator' => $creator,);
		}
		$stmt->close();
		$this->con->close();
		return $user_info;
	}

	public function toggle_user($id, $status){
		
		$stmt = $this->con->prepare("UPDATE tbl_users SET status = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function reset_password($id, $password){
		$password = md5($password);
		$stmt = $this->con->prepare("UPDATE tbl_users SET password = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $password, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}
}