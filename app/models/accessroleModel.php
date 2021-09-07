<?php

class accessroleModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}

	public function process_access_role($id, $rolename, $description){
		$status = 1;
		$result = 0;

		if ($id == 0){
			$stmt = $this->con->prepare("INSERT INTO tbl_access_roles (rolename, description, status) VALUES (?, ?, ?)");
			$stmt->bind_param("sss", $rolename, $description, $status);
			$stmt->execute();
			$result = 1;
		}
		else{
			$query_role = "SELECT * FROM tbl_access_roles WHERE record_id = ".$id;

			if (mysqli_num_rows(mysqli_query($this->con, $query_role)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_access_roles SET rolename = ?, description = ? WHERE record_id = ?");
				$stmt->bind_param("sss", $rolename, $description, $id);
				$stmt->execute();
				$result = 2;
			}
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_access_roles($status){
		$stmt = $this->con->prepare("SELECT record_id, rolename, description, status FROM tbl_access_roles WHERE status = ".$status);
		$stmt->execute();
		$stmt->bind_result($id, $rolename, $description, $status);
		$roles = array();

		while ($stmt->fetch()) {
			$roles[] = array('id' => $id, 
							'rolename' => $rolename, 
							'description' => $description,
							'status' => $status);
		}
		$stmt->close();
		$this->con->close();
		return $roles;
	}

	public function get_access_role_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, rolename, description, status FROM tbl_access_roles WHERE record_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $rolename, $description, $status);
		$role_info = array();

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

	public function toggle_role($id, $status){
		
		$stmt = $this->con->prepare("UPDATE tbl_access_roles SET status = ? WHERE record_id = ?");
		$stmt->bind_param("ss", $status, $id);
		$stmt->execute();
		$result = 1;		

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_access_categories($status){

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, category_name, description, status FROM tbl_access_category WHERE status = ?");
		$stmt->bind_param("s", $status);
		$stmt->execute();
		$stmt->bind_result($id, $name, $description, $status);
		$categories = array();

		while ($stmt->fetch()) {
			$categories[] = array('id' => $id, 
							'name' => $name, 
							'description' => $description,
							'status' => $status);
		}
		$stmt->close();
		$this->con->close();
		return $categories;

	}

	public function get_access_codes($category, $roleid = 0){

		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, category_id, access_code, description, status FROM tbl_access_code WHERE category_id = ?");
		$stmt->bind_param("s", $category);
		$stmt->execute();
		$stmt->bind_result($id, $categoryid, $code, $description, $status);
		$codes = array();

		while ($stmt->fetch()) {
			$hasaccess = 0;

			if ($roleid){
				$hasaccess = $this->check_access($roleid, $code);
			}

			$codes[] = array('id' => $id, 
							'categoryid' => $categoryid,
							'code' => $code, 
							'description' => $description,
							'status' => $status,
							'hasaccess' => $hasaccess);
		}

		$stmt->close();
		$this->con->close();
		return $codes;
	}

	public function save_access_rights($id, $rights){

		$result = 0;
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("UPDATE tbl_access_rights SET status = 0 WHERE role_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();

		foreach ($rights as $key => $right) {
			$query = "SELECT * FROM tbl_access_rights WHERE role_id = ".$id." AND access_code_id = ".$right;

			if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
				$stmt = $this->con->prepare("UPDATE tbl_access_rights SET status = 1 WHERE role_id = ? AND access_code_id = ?");
				$stmt->bind_param("ss", $id, $right);
				$stmt->execute();
				$result = 1;
			}
			else{
				$stmt = $this->con->prepare("INSERT INTO tbl_access_rights (role_id, access_code_id, status) VALUES (?, ?, 1)");
				$stmt->bind_param("ss", $id, $right);
				$stmt->execute();
				$result = 1;
			}
		}

		$stmt->close();
		$this->con->close();
		return $result;
	}

	public function get_access_code_info($id){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, category_id, access_code, description, status FROM tbl_access_code WHERE record_id = ?");
		$stmt->bind_param("s", $id);
		$stmt->execute();
		$stmt->bind_result($id, $categid, $accesscode, $desc, $status);
		$codeinfo = array();

		while ($stmt->fetch()) {
			$codeinfo = array('id' => $id, 
							'categid' => $categid, 
							'accesscode' => $accesscode,
							'desc' => $desc,
							'status' => $status);
		}
		$stmt->close();
		$this->con->close();
		return $codeinfo;
	}

	public function get_access_role_rights($roleid){
		$db = new database();
		$this->con = $db->connection();
		$stmt = $this->con->prepare("SELECT record_id, role_id, access_code_id, status FROM tbl_access_rights WHERE role_id = ?");
		$stmt->bind_param("s", $roleid);
		$stmt->execute();
		$stmt->bind_result($id, $roleid, $codeid, $status);
		$rights = array();

		while ($stmt->fetch()) {
			$accesscodeinfo = $this->get_access_code_info($codeid);

			$rights[] = array('id' => $id, 
							'roleid' => $roleid,
							'codeid' => $codeid, 
							'accesscode' => $$accesscodeinfo['accesscode'],
							'status' => $status);
		}

		$stmt->close();
		$this->con->close();
		return $rights;
	}

	public function check_access($roleid, $accesscode){
		$result = 0;
		$db = new database();
		$this->con = $db->connection();
		$query = "SELECT * FROM tbl_access_rights tar
						INNER JOIN tbl_access_code tac ON tac.record_id = tar.access_code_id
						WHERE tar.role_id = ".$roleid." AND tac.access_code = '".$accesscode."' AND tar.status = 1";

		if (mysqli_num_rows(mysqli_query($this->con, $query)) >= 1){
			$result = 1;
		}
			
		return $result;
	}

}