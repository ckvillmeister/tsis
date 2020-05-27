<?php

class mainController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'main/index.php'));
	}

	public function logout(){
		$this->view()->render('login/login.php');
		session_destroy();
	}
}
?>