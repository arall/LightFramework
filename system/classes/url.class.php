<?php
/**
 * Url Class
 *
 * @package LightFramework\Core
 */
class Url{
	/**
	 * Current Url
	 * @var string
	 */
	public $url;

	/**
	 * Current App name
	 * @var string
	 */
	public $app;

	/**
	 * Current Action name
	 * @var string
	 */
	public $action;

	/**
	 * Url extra GET vars
	 * @var array
	 */
	public $vars;

	/**
	 * Contructor
	 */
	public function __construct(){
		//Get the current config
		$config = Registry::getConfig();
		//Fix extra slashes
		$dir = $config->get("dir");
		if($dir == "/"){
			$dir = "";
		}
		//Read URL
		$url = str_replace("//", "/", str_replace($dir, "", $_SERVER['REQUEST_URI']));
		//Exclude GET params
		if(strstr($url, "?")){
			$url = substr($url, 0, strpos($url, "?"));
		}elseif(strstr($url, "&")){
			$url = substr($url, 0, strpos($url, "&"));
		}
		//Set Url
		$this->url = $url;
		//Set App
		$this->app = $config->get("defaultApp");
		//Set Action
		$this->action = "index";
		if($url){
			//Fix / on first char (var[0] emty)
			if($url[0]=="/"){
				$url = substr($url, 1);
			}
			//Read Vars
			$vars = explode("/", $url);
			//Fix
			if($vars[1] && !$vars[0]){
				$this->app = $vars[1];
				if($vars[2]){
					$this->action = $vars[2];
				}
			}elseif($vars[0]){
				$this->app = $vars[0];
				if($vars[1]){
					$this->action = $vars[1];
				}
			}
			//GET Vars
			if(count($vars)>2){
				for($i=2;$i<count($vars);$i++){
					$this->vars[$i-2] = $vars[$i];
				}
			}
		}
		//POST is mandatory
		if($_POST['app']){
			$this->app = $_POST['app'];
		}
		if($_POST['action']){
			$this->action = $_POST['action'];
		}
	}

	/**
	 * Gets the full site Url
	 *
	 * @param  string $path Extra Url
	 * @return string       Url
	 */
	public static function site($path="") {
		$config = Registry::getConfig();
		$url = trim($config->get('url'), "/");
		$path = trim($path, "/");
		return $url."/".$path;
	}

	/**
	 * Gets the curren template Url
	 *
	 * @param  string $path Extra Url
	 * @return string       Url
	 */
	public static function template($path="") {
		$config = Registry::getConfig();
		$template = Registry::getTemplate();
		$url = trim($config->get('url'), "/");
		$path = trim($path, "/");
		return $url."/templates/".$template->name."/".$path;
	}
}
