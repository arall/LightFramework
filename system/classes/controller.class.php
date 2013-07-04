<?php

abstract class Controller{
	
	var $data = array();
	
	function __construct(){
		$this->init();
	}
	
	function getPath(){
		$config = Registry::getConfig();
		$url = Registry::getUrl();
		return $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$url->app.DIRECTORY_SEPARATOR;
	}
	
	function index(){
	}
	
	function setData($key, $data=""){
		$this->data[$key] = $data;
	}
	
	function view($view){
		$template = Registry::getTemplate();
       	$file = $this->getPath().DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $view).".view";
		$html = $template->loadTemplate($file, $this->data);
		return $html;
	}
	
	function render($data, $layer="index"){
		$config = Registry::getConfig();
		$template = Registry::getTemplate();
		$path = $config->get("path").DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$template->name.
		DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $layer).".layer";
		$vars['content'] = $data;
    	$html = $template->loadTemplate($path, $vars);
		echo $html;
	}
} 
?>