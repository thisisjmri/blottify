<?php

class Bootstrap{
	
	function __construct(){
		$url = isset($_GET['url']) ? $_GET['url']:null;
		$url = rtrim($url,'/');
		$url = explode('/', $url);
		//print_r($url);

		//check if empty and url
		if (empty($url[0])){
			require 'controllers/index.php';
			$controller = new Index();
			$controller->index();
			return false;
		}

		//check if file exist
		$file = 'controllers/'.$url[0].'.php';
		if (file_exists($file)){
			require $file;
		} else {
			$this->error();
		}

		$controller = new $url[0];
		$controller->loadModel($url[0]);
		// echo "loadmodel";

		//calling methods
		if (isset($url[2])){
			if (method_exists($controller, $url[2])){
				$controller->{$url[1]}($url[1]);
			}
			else {
				$this->error();
			}
		}
		else{
			if (isset($url[1])){
				if (method_exists($controller, $url[1])){
					$controller->{$url[1]}();
				} else{
					$this->error();
				}
			}else{
				$controller->index();
			}	
		}
	}

	function error(){
		require 'controllers/errror.php';
		$controller = new Errror();
		$controller->index();
		exit;
	}
}

?>