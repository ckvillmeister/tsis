<?php
require 'app/lib/view.php';

class controller{

	private $view;
	
	public function __construct(){
		$this->view = new view();
	}

	public function view(){
		return $this->view;
	}


}

?>