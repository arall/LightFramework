<?php

//Require composer autoloader if available
$composerAutoload = __DIR__ . '/../vendor/autoload.php';
if (is_file($composerAutoload)) {
    require_once($composerAutoload);
}

//Load Config
require_once(__DIR__ . '/../config.php');
