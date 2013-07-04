<?php
class Router{
	function delegate(){
		$url = Registry::getUrl();
		$config = Registry::getConfig();
		//Cargamos la App
		$app = $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$url->app.DIRECTORY_SEPARATOR.$url->app.".php";
		if (is_readable($app) == false) {
			die("No se puede leer la App '".$app."'");
		}
		try {
			include_once($app);
		}catch(Exception $e){
			echo "No se puede cargar la App '".$app."': ".$e->getMessage();
		}
		//Existe la Accion?
		$class = $url->app."Controller";
		$controller = new $class();
		$action = $url->action;
		if(method_exists($controller, $action)){
			$controller->$action();
		}else{
			die("Accion no encontrada: ".$action);
		}
	}
}
?>