<?php
class Registry {
	static private $url 		= NULL;
	static private $db 			= NULL;
	static private $config 		= NULL;
	static private $user 		= NULL;
	static private $template 	= NULL;
	static private $messages 	= array();

	static public function getUrl(){
		if (self::$url == NULL) {
			self::$url = new Url();
		}
		return self::$url;
    }
	static public function getDb(){
		$config = self::getConfig();
		if (self::$db == NULL) {
			self::$db = new Database($config->get("db_server"), $config->get("db_user"), $config->get("db_pass"), $config->get("db_name"));
		}
		return self::$db;
    }
	static public function getUser(){
		if (self::$user == NULL) {
			session_start();
			self::$user = new User($_SESSION['userId']);
		}
		return self::$user;
    }
    static public function getConfig(){
		if (self::$config == NULL) {
			global $_config;
			self::$config = new Config($_config);
		}
		return self::$config;
    }
	static public function getTemplate(){
		if (self::$template == NULL) {
			self::$template = new Template();
		}
		return self::$template;
    }
    static public function addMessage($message, $type=1, $field="", $url=""){
		session_start();
		$msg = new Message($message, $type, $field, $url);
		self::$messages[] = $msg;
		$_SESSION['messages'] = self::$messages;
		return true;
    }
    static public function getMessages($keep=0){
    	session_start();
    	self::$messages = array_merge(self::$messages, $_SESSION['messages']);
    	$messages = self::$messages;
    	if(!$keep){
    		self::$messages = array();
			$_SESSION['messages'] = array();
		}
		return $messages;
    }
}
?>