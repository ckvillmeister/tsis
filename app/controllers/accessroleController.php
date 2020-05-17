<?php

class accessroleController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'maintenance/access_role/index.php'));
	}
}
?>