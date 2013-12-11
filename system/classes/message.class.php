<?php
class Message {
	public $message;
	public $type;
	public $field;
	public $url;

	public function __construct($message, $type="notice", $field="", $url=""){
		$this->message = $message;
		$this->type = strtolower($type);
		$this->field = $field;
		$this->url = $url;
	}

	/**
	 * Fix for Bootstrap 3 Alert CSS's vs Form CSS's.
	 * 
	 * @return 	string 		CSS Class name
	 */
	public function getAlertType(){
		if($this->type=="error"){
			return "danger";
		}else{
			return $this->type;
		}
	}
}
?>