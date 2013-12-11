<?php

//PHP
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Madrid');
ini_set("session.gc_maxlifetime","140000");

//Config
$_config['defaultLang'] = "en_GB";
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
