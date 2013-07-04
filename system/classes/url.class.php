<?php 
class Url{
	var $url;
	public $app;
	public $action;
	public $vars; 
	/**
	* __construct
	*
	* Lee la url actual y setea las variables
	*
	*/
	public function __construct() {
		$config = Registry::getConfig();
		//Leemos la petición de la url
		$url = str_replace("//", "/", str_replace($config->get("dir"), "", $_SERVER['REQUEST_URI']));
		//Fix GET
		if(strstr($url, "?")){
			$url = substr($url, 0, strpos($url, "?"));
		}elseif(strstr($url, "&")){
			$url = substr($url, 0, strpos($url, "&"));
		}
		//Default App
		$this->app = $config->get("defaultApp");
		//Default Action
		$this->action = "index";
		if($url){
			//Leemos las variables
			$vars = explode("/", $url);
			if($vars[0])
				$this->app = $vars[0];
			if($vars[1])
				$this->action = $vars[1];
			if(count($vars)>2){
				for($i=2;$i<count($vars);$i++){
					$this->vars[$i-2] = $vars[$i];
				}
			}
		}
	}
	/**
	* site
	*
	* Devuelve una ruta absoluta del sitio 
	* apuntando a la ruta pasada por parámetro.
	*
	*/
	static function site($path) {
		$config = Registry::getConfig();
		return $config->get('url')."/".$path;
	}
	/**
	* template
	*
	* Devuelve una ruta absoluta del template 
	* apuntando a la ruta pasada por parámetro.
	*
	*/
	static function template($path) {
		$config = Registry::getConfig();
		$template = Registry::getTemplate();
		return $config->get('url')."/templates/".$template->name."/".$path;
	}
}
?>