<?php 
class Url{
	var $url;
	public $app;
	public $action;
	public $vars; 
	/**
	* __construct
	*
	* Reads current URL and set vars
	*
	*/
	public function __construct() {
		$config = Registry::getConfig();
		//Read URL
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
			//Read Vars
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
	* Returns full site URL
	*
	*/
	static function site($path) {
		$config = Registry::getConfig();
		return $config->get('url')."/".$path;
	}
	/**
	* template
	*
	* Returns full template URL
	*
	*/
	static function template($path) {
		$config = Registry::getConfig();
		$template = Registry::getTemplate();
		return $config->get('url')."/templates/".$template->name."/".$path;
	}
}
?>