<?php
class Database {
    var $query;
    var $result;
    var $link;
    public $registry;
    private $server;
    
    function Database($server="localhost", $user="", $passw="", $dbName="") {
      	if(!function_exists("mysql_connect")) return false; 	
      	$this->link = mysql_connect($server, $user, $passw) or die("Error: Cannot connect to db ".$server);
      	mysql_select_db($dbName) or die("Error: Cannot read the database");
      	$this->mysql_set_charset("utf8");
      	$opened = true;
      	return $opened;
    }
    function mysql_set_charset($charset="utf8"){
	    return $this->query("SET character_set_results='$charset',character_set_client='$charset',character_set_connection='$charset',character_set_database='$charset',character_set_server='$charset'");
	}

    function close() {
    	if(!function_exists("mysql_close")) return false;
    	mysql_close($this->link);
    	$opened = false;
    	return $opened;
    }
    
    function query($query){
      	$this->query = $query;
      	$this->result = mysql_query($query);
      	return $this->result;
    }
    
    function fetcharray($result=null){
    	if(!$result)
    		$result=$this->result;
      	return mysql_fetch_array($result);
    }
    
    function loadArrayList(){
    	while($row = $this->fetcharray()){
			$array[] = $row;	
		}
		return $array;
    }
    
    function fetchrow($result=null){
    	if(!$result)
    		$result = $this->result;
      	return mysql_fetch_row($result);
    }
    
    function fetchassoc($result=null){
    	if(!$result)
    		$result = $this->result;
      	return mysql_fetch_assoc($result);
    }
    
    function getNumRows($result=null){
    	if(!$result)
    		$result = $this->result;
      	return mysql_num_rows($result);
    }
    
    function freeresult($result=null){
    	if(!$result)
    		$result = $this->result;
      	return mysql_free_result($result);
    }
    
	  function lastid(){
      	return mysql_insert_id();
    }
    
    function getError($link=null){
    	if(!$link)
    		$link = $this->link;
    	return "Server: "._SERVER_DB_." ".mysql_errno($link).": ".mysql_error($link);
    }
    
    function __destruct(){
	    $this->close();
	    unset($this);
    }
}
?>