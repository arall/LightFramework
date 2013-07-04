<?php
//Config
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);
date_default_timezone_set('Europe/Madrid');
ini_set("session.gc_maxlifetime","140000");

//Pass trought index
define("_EXE", 1);

//Startup
require('system/startup.php');

?>