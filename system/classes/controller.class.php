<?php

abstract class Controller{
	
	var $data = array();
	
	function __construct(){
		$this->init();
	}
	
	function getPath($app=""){
		$config = Registry::getConfig();
		$url = Registry::getUrl();
		if(!$app)
			$app = $url->app;
		return $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR;
	}
	
	function setData($key, $data=""){
		$this->data[$key] = $data;
	}
	
	function view($view, $app=""){
		$template = Registry::getTemplate();
		$path = $this->getPath($app);
		//Including the controller as data, to enable modules/views inside other views
		$this->data['controller'] = $this;
       	$file = $path.DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $view).".view";
		$html = $template->loadTemplate($file, $this->data);
		return $html;
	}
	
	function render($data, $layer="index"){
		$template = Registry::getTemplate();
		$config = Registry::getConfig();
		$path = $config->get("path").DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$template->name.
			DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $layer).".layer";
		$vars['content'] = $data;
    	$html = $template->loadTemplate($path, $vars);
		echo $html;
	}
} 
?>