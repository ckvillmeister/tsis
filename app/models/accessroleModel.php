<?php

class accessroleModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function process_access_role($param = array()){
		$id = $param['id'];
		$rolename = $param['rolename'];
		$description = $param['description'];
		$userid = $param['userid'];
		$datetime = $param['datetime'];
		$status = 1;
		$query_role = "SELECT * FROM tbl_access_role WHERE record_id = ".$id;
		$result = 0;

		if (mysqli_num_rows(mysqli_query($this->con, $query_role)) >= 1){
			$stmt = $this->con->prepare("UPDATE tbl_access_role SET role_name = ?, description = ?, updated_by = ?, date_updated = ? WHERE record_id = ?");
			$stmt->bind_param("sssss", $rolename, $description, $userid, $datetime, $status);
			$stmt->execute();
			$result = 2;
		}
		else{
			$stmt = $this->con->prepare("INSERT INTO tbl_access_role (role_name, description, created_by, date_created, status) VALUES (?, ?, ?, ?, ?)");
			$stmt->bind_param("sssss", $rolename, $description, $userid, $datetime, $status);
			$stmt->execute();
			$result = 1;
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_access_roles(){
		$stmt = $this->con->prepare("SELECT record_id, role_name, description, status FROM tbl_access_role");
		$stmt->execute();
		$stmt->bind_result($id, $rolename, $description, $status);

		while ($stmt->fetch()) {
			$roles[] = array('id' => $id, 
							'rolename' => $rolename, 
							'description' => $description,
							'status' => $this->status($status));
		}
		$stmt->close();
		$this->con->close();
		return $roles;
	}

	public function get_access_role_info($param = array()){
		$id = $param['id'];
		$stmt = $this->con->prepare("SELECT record_id, role_name, description, status FROM tbl_access_role WHERE record_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $rolename, $description, $status);

		while ($stmt->fetch()) {
			$role_info = array('id' => $id, 
							'rolename' => $rolename, 
							'description' => $description,
							'status' => $this->status($status));
		}
		$stmt->close();
		$this->con->close();
		return $role_info;

	}
}