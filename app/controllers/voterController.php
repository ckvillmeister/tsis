<?php

class voterController extends controller{

	private $voterObj;

	public function index(){
		//$this->voterObj = new voterModel();
		//$voters = $this->voterObj->get_voters_list();
		$this->view()->render('main.php', array('content' => 'voter/index.php'));
	}

	public function get_voters_list(){
		//$content = file_get_contents(PATH_VIEW.'/voter/table.php');
		//echo $content;
		$this->voterObj = new voterModel();
		$voters = $this->voterObj->get_voters_list();
		$this->view()->render('voter/table.php', array('voters' => $voters));
	}
}
?>