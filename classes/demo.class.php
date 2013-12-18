<?php
class Demo extends Model {

	public $id;
	public $userId;
	public $string;
	public $dateInsert;
	public $dateUpdate;

	public function init(){
		parent::$dbTable = "demos";
		parent::$reservedVarsChild = self::$reservedVarsChild;
	}

	public function validateInsert(){
		//Empty string?
		if(!$this->string){
			Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_EMPTY"), "error", "string");
		//Already exising?
		}elseif($this->getDemoByString($this->string)){
			Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_TAKEN"), "error", "string");
        }
        //Return messages avoiding deletion
        return Registry::getMessages(true);
	}

	public function preInsert(){
		$user = Registry::getUser();
		$this->userId = $user->id;
		$this->dateInsert = date("Y-m-d H:i:s");
	}

	public function validateUpdate(){
		//Empty string?
		if(!$this->string){
			Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_EMPTY"), "error", "string");
		//Already exising?
		}elseif($this->getDemoByString($this->string, $this->id)){
			Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_TAKEN"), "error", "string");
        }
        //Return messages avoiding deletion
        return Registry::getMessages(true);
	}

	public function preUpdate(){
		$this->dateUpdate = date("Y-m-d H:i:s");
	}

	public function getDemoByString($string="", $ignoreId=0){
		$db = Registry::getDb();
		$query = "SELECT * FROM `demos` WHERE `string`!='".mysql_real_escape_string($string)."'";
		if($ignoreId){
			$query .= " AND `id`!=".(int)$ignoreId;
		}
		if($db->Query($query)){
			if($db->getNumRows()){
				$row = $db->fetcharray();
				return new Demo($row);
			}
		}
	}

	public function select($data=array(), $limit=0, $limitStart=0, &$total=null){
		$db = Registry::getDb();
		$query = "SELECT * FROM `demos` ";
		//Total
		if($db->Query($query)){
			$total = $db->getNumRows();
			//Order
			if($data['order'] && $data['orderDir']){
				//Secure Field
				$vars = array_keys(get_class_vars(__CLASS__));
				$orders = array("ASC", "DESC");
				if(in_array($data['order'], $vars) && in_array($data['orderDir'], $orders)){
					$query .= " ORDER BY `".mysql_real_escape_string($data['order'])."` ".mysql_real_escape_string($data['orderDir']);
				}
			}
			//Limit
			if($limit){
				$query .= " LIMIT ".(int)$limitStart.", ".(int)$limit;
			}
			if($total){
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
	}
}
