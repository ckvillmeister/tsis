<?php

class errorController extends controller{

	public function index(){
		if ($this->is_session_empty()){
			header('location:'.ROOT);
		}
		else{
			$settings_model = new settingsModel();
			$system_name = $settings_model->get_system_name();
			
			$this->view()->render('error/index.php', array('system_name' => $system_name));
		}
	}
}
?>