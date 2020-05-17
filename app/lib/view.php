<?php

class view{

	public function render($url, $data = array()){
		require PATH_VIEW.$url;
	}
}

?>