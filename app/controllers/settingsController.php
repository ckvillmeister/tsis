<?php

class settingsController extends controller{
	
	public function index(){
		$this->view()->render('main.php', array('content' => 'maintenance/system_settings/index.php'));
	}

}

?>