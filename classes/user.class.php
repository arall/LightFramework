<?php
class User extends Model {
	
	var $id;
	var $username;
	
	public function init(){
		parent::$dbTable = "users";
		parent::$reservedVars = self::$reservedVars;
	}
	
	function preInsert(){
		//Passwd encryption
		//$this->password = md5(sha1(trim($this->password)));
	}
	
	function selectUsers(){
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
}
?>