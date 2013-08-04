<?php
class Demo extends Model {
	
	var $id;
	var $string;
	
	public function init(){
		parent::$dbTable = "demos";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}
	
	function preUpdate(){
		//Generate random string
		$this->string = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
	}
	
	public function selectDemos(){
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