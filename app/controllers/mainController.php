<?php

class mainController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'main/index.php'));
	}
}
?>