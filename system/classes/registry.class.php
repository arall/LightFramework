<?php
/**
 * Registry Class
 *
 * @package LightFramework\Core
 */
class Registry{

	/**
	 * Current Url object
	 * @var object
	 */
	private static $url = NULL;

	/**
	 * Current Database object
	 * @var object
	 */
	private static $db = NULL;

	/**
	 * Current Config object
	 * @var object
	 */
	private static $config = NULL;

	/**
	 * Current User object
	 * @var object
	 */
	private static $user = NULL;

	/**
	 * Current Template object
	 * @var object
	 */
	private static $template = NULL;

	/**
	 * Current Messages array
	 * @var array
	 */
	private static $messages = array();

	/**
	 * Current Language object
	 * @var object
	 */
	private static $language = NULL;

	/**
	 * Current Debug values
	 * @var array
	 */
	private static $debug = array();

	/**
	 * Get the current Debug Log
	 *
	 * @param  string $key Log Key (variable)
	 * @return multiple      Debug Log or Value of passed Log Key
	 */
	public static function getDebug($key=""){
		if($key){
			return self::$debug[$key];
		}else{
			return self::$debug;
		}
    }

    /**
     * Set a Debug Log object
     *
     * @param string $key  Key
     * @param string $data Value
     */
    public static function setDebug($key, $data){
		self::$debug[$key] = $data;
    }

    /**
     * Get the current Url object
     *
     * @return object Url
     */
	public static function getUrl(){
		if(self::$url == NULL){
			self::$url = new Url();
		}
		return self::$url;
    }

    /**
     * Get the current Language object
     *
     * @param  string $lang Desired language
     * @return object Url
     */
    public static function getLanguage($lang=""){
		if(self::$language == NULL){
			self::$language = new Language($lang);
		}
		return self::$language;
    }

    /**
     * Get the current Data Base object
     * @return object Data Base
     */
	public static function getDb(){
		$config = self::getConfig();
		if(self::$db == NULL){
			self::$db = new Database($config->get("dbHost"), $config->get("dbUser"), $config->get("dbPass"), $config->get("dbName"));
		}
		return self::$db;
    }

    /**
     * Get the current User object
     * @return object User
     */
	public static function getUser(){
		if(self::$user == NULL){
			session_start();
			self::$user = new User($_SESSION['userId']);
		}
		return self::$user;
    }

    /**
     * Get the current Config object
     * @return object Config
     */
    public static function getConfig(){
		if(self::$config == NULL){
			global $_config;
			self::$config = new Config($_config);
		}
		return self::$config;
    }

    /**
     * Get the current Template object
     * @return object Template
     */
	public static function getTemplate(){
		if(self::$template == NULL){
			self::$template = new Template();
		}
		return self::$template;
    }

    /**
     * Add a message on the current session
     *
     * @param string  $message Message itself
     * @param integer $type    Type of message
     * @param string  $field   Related Form field
     * @param string  $url     Url to redirect
     */
    public static function addMessage($message="", $type=1, $field="", $url=""){
		session_start();
		$msg = new Message($message, $type, $field, $url);
		$_SESSION['messages'][] = $msg;
		self::$messages[] = $_SESSION['messages'];
		return true;
    }

    /**
     * Get the current session messages
     *
     * @param  bool  $keep Don't delete the messages
     * @return array List of Message objects
     */
    public static function getMessages($keep=false){
    	session_start();
    	$messages = $_SESSION['messages'];
    	self::$messages = $messages;
    	if(!$keep){
    		self::$messages = array();
			$_SESSION['messages'] = array();
		}
		return $messages;
    }

    /**
     * Translate a string using the current Language
     *
     * @param  string $string String to be translated
     * @return string Translated string
     */
    public static function translate($string=""){
    	$lang = self::getLanguage();
		return $lang->translate($string);
    }
}
