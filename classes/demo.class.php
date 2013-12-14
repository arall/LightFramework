<?php
class Demo extends Model {

	public $id;
	public $string;

	public function init(){
		parent::$dbTable = "demos";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

	public function preInsert(){
		//Generate random string
		$this->string = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6);
	}

	public function getTotalDemos(){
		$db = Registry::getDb();
		$query = "SELECT count(id) as total FROM demos";
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return $row['total'];
			}
		}
	}

	public function getLastDemo(){
		$db = Registry::getDb();
		$query = "SELECT * FROM demos ORDER BY id DESC LIMIT 1";
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new Demo($row);
			}
		}
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
