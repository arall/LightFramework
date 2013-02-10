<?php
//Config
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', 1);

//Start session
session_start();

//Pass trought index
define("_EXE", 1);

//Classes
include("classes/database.class.php");

//Database
$db = new Database("server", "user", "password", "db");

?>
<html>
	<head>
		<link rel="stylesheet" href="/template/css/default.css" />
	</head>
	<body>
		<?php
		//Option Swtich
		switch($_REQUEST['option']){
			default:
				include("template/views/example.view.php");
			break;
		}
		?>
	</body>
</html>