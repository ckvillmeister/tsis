<?php

class dashboardController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'dashboard/index.php'));
	}
}
?>