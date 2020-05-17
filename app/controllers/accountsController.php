<?php

class accountsController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'maintenance/accounts/index.php'));
	}
}
?>