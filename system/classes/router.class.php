<?php
class Router{
	public function delegate(){
		$url = Registry::getUrl();
		$config = Registry::getConfig();
		//Load App
		$app = $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$url->app.DIRECTORY_SEPARATOR.$url->app.".php";
		if (is_readable($app) == false) {
			if($config->get("debug"))
				die("App not found: ".$app);
			else
				redirect(Url::site());
		}
		include_once($app);
		//Acction exists?
		$class = $url->app."Controller";
		$controller = new $class();
		$action = $url->action;
		if(method_exists($controller, $action)){
			$controller->$action();
		}else{
			if($config->get("debug"))
				die("Acction not found: ".$action);
			else
				redirect(Url::site());
		}
	}
}
?>
