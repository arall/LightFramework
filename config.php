<?php
//Config
$_config['template'] = "bootstrap";
$_config['defaultApp'] = "demo";
$_config['debug'] = true;

//Database
$_config['db_server'] = "localhost";
$_config['db_user'] = "root";
$_config['db_pass'] = "";
$_config['db_name'] = "lightFramework";

//Urls/Paths
$_config['path'] = dirname(__FILE__);
$_config['host'] = $_SERVER["SERVER_NAME"];
$_config['dir'] = str_replace("index.php","",$_SERVER["SCRIPT_NAME"]);
$_config['url'] = "http://".$_config['host'].$_config['dir'];

//Functions
function print_pre($array=""){
	echo "<pre>";
	print_r($array);
	echo "</pre>";
}

function redirect($url, $message="", $type=""){
	if($message){
		Registry::addMessage($message, $type);
	}
	header("Location: ".$url);
}
?>
