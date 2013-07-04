<?php
class Demo extends Model {
	
	var $id;
	var $string;
	
	public function init(){
		parent::$dbTable = "demos";
		parent::$reservedVars = self::$reservedVars;
	}
	
	function preUpdate(){
		//Generate random string
		$r = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
		$this->string = $r;
	}
	
	function selectDemos(){
		$db = Registry::getDb();
		$query = "SELECT * FROM demos";
		if($db->Query($query)){
			if($db->getNumRows()){
				$rows = $db->loadArrayList();
				foreach($rows as $row){
					$result[] = new Demo($row);
				}
				return $result;
			}
		}
	}
}
?>