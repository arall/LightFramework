<?php
class Config{
	private $data;
	
    public function __construct($vars){
    	if(is_array($vars)) {
	    	$this->setByArray($vars);
    	}
    }
	
    public function set($name,$value){
	    $this->data[$name]=$value;
    }
    
    public function get($name) {
	    return $this->data[$name];
    }
    
    public function setByArray($array){
    	if(is_array($array))
    		foreach($array as $name=>$value)
    			$this->set($name,$value);
    }
} 
?>