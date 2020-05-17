<?php

class reportController extends controller{

	public function ward_list(){
		$settingsObj = new settingsModel();
		$barangay = $settingsObj->get_barangay();
		$this->view()->render('main.php', array('content' => 'report/ward_list/index.php', 'barangay' => $barangay));
	}

	public function get_ward_list(){
		$barangay = $_POST['barangay'];
		$reportObj = new reportModel();
		$wardlist = $reportObj->get_ward_list(array('barangay' => $barangay));
		$this->view()->render('report/ward_list/wardlist.php', array('wardlist' => $wardlist));
	}
}
?>