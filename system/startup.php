<?php

//Autoload Classes
function __autoload($class_name)
{
    //System
    $file = "system".DIRECTORY_SEPARATOR."classes".DIRECTORY_SEPARATOR.strtolower($class_name).".class.php";
    if (is_file($file)) {
        include $file;

        return;
    }
    //Custom
    $file = "classes".DIRECTORY_SEPARATOR.strtolower($class_name).".class.php";
    if (is_file($file)) {
        include $file;

        return;
    }
}

//Vendors
require 'vendor/autoload.php';

//Languages
$language = new Language();

//Registry
$registry = new Registry();

//Router
$router = new Router();
$router->delegate();
