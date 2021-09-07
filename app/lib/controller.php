<?php

class controller{

	private $view;
	private $userid;
	
	public function __construct(){
		if (session_status() === PHP_SESSION_NONE) {
		    session_start();
		}
		$this->view = new view();
	}

	public function view(){
		return $this->view;
	}

	public function is_session_empty(){
		if (isset($_SESSION['user_id']) == ''){
			return 1;
		}

		return 0;
	}

	public function get_sys_image(){
		
	}

}

?>