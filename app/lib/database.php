<?php

class database{

	private $hostname = "localhost";
	private $username = "root";
	private $password = "";
	private $database_name = "tsis_db";
	private $conn;
	
	public function connection(){
		$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database_name);

		if ($this->conn->connect_error){
			echo 'Failed to connect to MySQL '. mysqli_connect_error();
		}
		else{
			mysqli_select_db($this->conn, $this->database_name);
			$this->conn = new mysqli($this->hostname, $this->username, $this->password, $this->database_name);
<<<<<<< HEAD
			$this->conn->set_charset("ISO-8859-1");
=======
			//$this->conn->set_charset("ISO-8859-1");
			$this->conn->set_charset("UTF8");
>>>>>>> 4f96080407d82655cbd43e814e9cad2dccec95bb
			return $this->conn;
		}
	}

}
	
?>