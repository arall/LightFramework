<?php

//Pass trought index
define("_EXE", 1);

//Configuration
file_exists("config.php") OR die("Can't find config.php");
include "config.php";

//Composer autoload
file_exists("vendor/autoload.php") OR die("Composer required");
require "vendor/autoload.php";

//Language init
$language = new Language();

//Registry init
$registry = new Registry();

//Router init
$router = new Router();

//Delegate
$router->delegate();
