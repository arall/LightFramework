<?php

//Configuration
include("config.php");

//Autoload Classes
function __autoload($class_name) {
	//System
	$file = "system".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR.strtolower($class_name).".class.php";
    if (is_file($file)){
        include $file;
        return;
    }
	//Custom
    $file = "classes".DIRECTORY_SEPARATOR.strtolower($class_name).".class.php";
    if (is_file($file)){
        include $file;
        return;
    }
}

//Libs
//SQL Formater (For better debugging)
include 'system/libs/SqlFormatter.php';
//PHPMailer
include 'system/libs/phpmailer/class.phpmailer.php';
include 'system/libs/phpmailer/class.smtp.php';
include 'system/libs/phpmailer/class.pop3.php';

//Languages
$language = new Language();

//Registry
$registry = new Registry();

//Router
$router = new Router();
$router->delegate();

