<?php
abstract class Controller{
	var $data = array();
	
	public function __construct(){
		$this->init();
	}
	public function getPath($app=""){
		$config = Registry::getConfig();
		$url = Registry::getUrl();
		if(!$app)
			$app = $url->app;
		return $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR;
	}
	public function setData($key, $data=""){
		$this->data[$key] = $data;
	}
	public function view($view, $app=""){
		$template = Registry::getTemplate();
		$path = $this->getPath($app);
		//Including the controller as data, to enable modules/views inside other views
		$this->data['controller'] = $this;
       	$file = $path.DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $view).".view";
		$html = $template->loadTemplate($file, $this->data);
		return $html;
	}
	public function render($data, $layer="index"){
		$template = Registry::getTemplate();
		$config = Registry::getConfig();
		$path = $config->get("path").DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$template->name.
			DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $layer).".layer";
		$vars['content'] = $data;
		$vars['controller'] = $this;
    	$html = $template->loadTemplate($path, $vars);
		echo $html;
	}
	public final function ajax() {
    	$messages = Registry::getMessages();
    	//Fix preserve on redirections
    	if(count($messages)){
    		foreach($messages as $message){
    			if($message->url){
    				Registry::addMessage($message->message, $message->type, $message->field, $message->url);
    			}
    		}
    	}
    	echo json_encode($messages);
    }
} 
?>
