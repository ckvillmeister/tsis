<?php

class authenticationModel extends model{

	private $con;

	public function __construct(){
		$db = new database();
		$this->con = $db->connection();
	}
	
	public function validate_login($param = array()){
		$username = $param['username'];
		$password = md5($param['password']);

		$stmt = $this->con->prepare("SELECT record_id, username, firstname, middlename, lastname FROM tbl_users WHERE username = ? AND password = ?");
		$stmt->bind_param("ss", $username, $password);
		$stmt->execute();
		$stmt->bind_result($id, $username, $firstname, $middlename, $lastname);
		$user = array();
		while ($stmt->fetch()) {
			$user['info'] = array('user_id' => $id, 
								'username' => $username, 
								'firstname' => $firstname, 
								'middlename' => $middlename,
								'lastname' => $lastname);
		}
		$stmt->close();
		$this->con->close();
		return $user;
	}
}

?>