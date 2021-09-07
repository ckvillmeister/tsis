<?php

class route
{	

	public function __construct($url){
		$this->get($url);
	}

	public function get($url)
	{
		$arr_url = explode('/', rtrim($url, '/'));
		$filename = rtrim($arr_url[0], '/').'Controller.php';
		$class = rtrim($arr_url[0], '/').'Controller';

		if($arr_url[0] == ""){
			$filename = 'authenticationController.php';
			$class = 'authenticationController';
		}

		if (file_exists(PATH_CONTROLLER.$filename))
		{
			require PATH_CONTROLLER.$filename;
			$controller = new $class();

			if (isset($arr_url[1]) != ""){
				$function = $arr_url[1];

				if (method_exists($controller, $function)){
					$controller->$function();
				}
				else{
					require PATH_CONTROLLER.'errorController.php';
					$controller = new errorController();
					$controller->index();
				}
				
			}
			else{

				if (method_exists($controller, 'index')){
					$controller->index();
				}
				else{
					require PATH_CONTROLLER.'errorController.php';
					$controller = new errorController();
					$controller->index();
				}
			}
		} 
		else{
			require PATH_CONTROLLER.'errorController.php';
			$controller = new errorController();
			$controller->index();
		}
		
	}

}


?>