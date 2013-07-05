<?php
class User extends Model {
	
	var $id;
	var $rolId;
	var $username;
	var $password;
	var $lastVisitDate;
	var $registerDate;
	var $updateDate;
	
	var $roles = array("Visitor", "Registred", "Admin");
	public static $reservedVarsChild = array("roles");
	
	public function init(){
		parent::$dbTable = "users";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}
	
	public function login($username, $password){
		$db = Registry::getDb();
		$query = "SELECT id FROM ".self::$dbTable." WHERE 
		username='".htmlspecialchars(mysql_real_escape_string(trim($username)))."'
		AND password='".md5(sha1(trim($password)))."' LIMIT 1;";
		if($db->query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				//Set Session
				session_start();
				$_SESSION['userId'] = $row['id'];
				//Update lastVisitDate
                return 1;
			}
		}
	}
	
	function validateInsert(){
		//Check if this username already exists
		if($this->getIdByEmail($this->email)){
			//$mensajes->insert("This username is already registred");
		}
		//Password?
		if(!$this->password || strlen($this->password)<6){
			//$mensajes->insert("Password must be at least 6 chars long", 4, "password");
		}
		//return $mensajes->getMensajes();
	}
	
	public function logout(){
		session_start();
		$_SESSION = array();
		session_unset();
		session_destroy();
		return 1;
	}
	
	function preInsert(){
		//Passwd encryption
		$this->password = md5(sha1(trim($this->password)));
		//Register Date
		$this->registerDate = date("Y-m-d H:i:s");
	}
	
	function preUpdate(){
		//Update Date
		$this->updateDate = date("Y-m-d H:i:s");
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