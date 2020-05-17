<?php

class errorController extends controller{

	public function index(){
		$this->view()->render('main.php', array('content' => 'error/index.php'));
	}
}
?>