<?php
class User extends Model {
	
	var $id;
	var $roleId;
	var $email;
	var $username;
	var $password;
	var $registerDate;
	var $lastvisitDate;

	var $roles = array("Registered", "Admin");
	public static $reservedVarsChild = array("roles");
	
	public function init(){
		parent::$dbTable = "users";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}
	
	public function login($login, $password){
		$db = Registry::getDb();
		$query = "SELECT * FROM users WHERE 
		(	username='".htmlspecialchars(mysql_real_escape_string(trim($login)))."' OR 
			email='".htmlspecialchars(mysql_real_escape_string(trim($login)))."'
		) AND password='".md5(sha1(trim($password)))."' LIMIT 1;";
		if($db->query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				$user = new User($row);
				//Set Session
				session_start();
				$_SESSION['userId'] = $user->id;
				//Update lastVisitDate
				$user->lastvisitDate = date("Y-m-d H:i:s");
				$user->update();
                return true;
			}
		}
	}
	
	function validateInsert(){
		//Check username already exists
		if(!$this->username){
			Registry::addMessage("This field is requiered", "error", "username");
		}elseif($this->getUserByUsername($this->username)){
			Registry::addMessage("This username is already registred", "error", "username");
		}
		//Check email
		if(!$this->email){
			Registry::addMessage("This field is requiered", "error", "email");
		}elseif($this->getUserByEmail($this->email)){
			Registry::addMessage("This email is already registred", "error", "email");
		}
		//Password?
		if(!$this->password || strlen($this->password)<6){
			Registry::addMessage("Password must be at least 6 chars long", "error", "password");
		}
		return Registry::getMessages(true); 
	}
	
	public function logout(){
		session_start();
		$_SESSION = array();
		session_unset();
		session_destroy();
		return true;
	}
	
	function preInsert(){
		//Passwd encryption
		$this->password = md5(sha1(trim($this->password)));
		//Register Date
		$this->registerDate = date("Y-m-d H:i:s");
	}
	
	public function selectUsers(){
		$db = Registry::getDb();
		$query = "SELECT * FROM users";
		if($db->Query($query)){
			if($db->getNumRows()){
				$rows = $db->loadArrayList();
				foreach($rows as $row){
					$result[] = new User($row);
				}
				return $result;
			}
		}
	}
	
	public function getUserByEmail($email){
		$db = Registry::getDb();
		$query = "SELECT * FROM users WHERE email='".htmlentities(mysql_real_escape_string($email))."'";
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new User($row);
			}
		}
	}

	public function getUserByUsername($username){
		$db = Registry::getDb();
		$query = "SELECT * FROM users WHERE username='".htmlentities(mysql_real_escape_string($username))."'";
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new User($row);
			}
		}
	}
}
?>