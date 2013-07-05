<?php
class Registry {
	static private $url 		= NULL;
	static private $db 			= NULL;
	static private $config 		= NULL;
	static private $user 		= NULL;
	static private $template 	= NULL;
	
	static public function getUrl() {
		if (self::$url == NULL) {
			self::$url = new Url();
		}
		return self::$url;
    }
	static public function getDb() {
		$config = self::getConfig();
		if (self::$db == NULL) {
			self::$db = new Database($config->get("db_server"), $config->get("db_user"), $config->get("db_pass"), $config->get("db_name"));
		}
		return self::$db;
    }
	static public function getUser() {
		if (self::$user == NULL) {
			session_start();
			self::$user = new User($_SESSION['userId']);
		}
		return self::$user;
    }
    static public function getConfig() {
		if (self::$config == NULL) {
			global $_config;
			self::$config = new Config($_config);
		}
		return self::$config;
    }
	static public function getTemplate() {
		if (self::$template == NULL) {
			self::$template = new Template();
		}
		return self::$template;
    }
}
?>