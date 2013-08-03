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
}
?>