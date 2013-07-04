<?php
//Config
$_config['template'] = "bootstrap";
$_config['defaultApp'] = "info";

//Database
$_config['db_server'] = "localhost";
$_config['db_user'] = "root";
$_config['db_pass'] = "root";
$_config['db_name'] = "lightframework";

//Urls/Paths
$_config['path'] = dirname(__FILE__);
$_config['host'] = $_SERVER["SERVER_NAME"];
$_config['dir'] = str_replace("index.php","",$_SERVER["SCRIPT_NAME"]);
$_config['url'] = "http://".$_config['host'].$_config['dir'];

function print_pre($txt){
	echo "<pre>";
	print_r($txt);
	echo "</pre>";
}

?>