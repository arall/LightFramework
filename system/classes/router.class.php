<?php
/**
 * Router Class
 *
 * @package LightFramework\Core
 */
class Router{

	/**
	 * Load the correct App and launch an App Action
	 */
	public function delegate(){
		//Get the current Config
		$config = Registry::getConfig();
		if($config->get("debug")){
			Registry::setDebug("started", microtime(true));
		}
		//Get the current Url
		$url = Registry::getUrl();
		//Load App
		$app = $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$url->app.DIRECTORY_SEPARATOR.$url->app.".php";
		//Check if the app path exists
		if(is_readable($app)==false){
			if($config->get("debug"))
				die("App not found: ".$app);
			else
				redirect(Url::site());
		}
		//Load the App
		include_once($app);
		//Check if the acction exists
		$class = $url->app."Controller";
		$controller = new $class();
		$action = $url->action;
		if(method_exists($controller, $action)){
			//Launch the App Action
			$controller->$action();
			//Preserve Current Debug
            Registry::preserveDebug();
		}else{
			if($config->get("debug"))
				die("Acction not found: ".$action);
			else
				redirect(Url::site());
		}
	}
}
