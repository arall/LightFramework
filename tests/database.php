<?php

//Set Test Database to Framework
$config = Registry::getConfig();
$config->set("dbHost", PHPUNIT_DBHOST);
$config->set("dbUser", PHPUNIT_DBUSER);
$config->set("dbPass", PHPUNIT_DBPASS);
$config->set("dbName", PHPUNIT_DBNAME);

//Load Database Dump
$sqlDumpPath = "lightframework.sql";
if (!file_exists($sqlDumpPath)) {
    die("lightframework.sql dump file not found");
} else {
    $sqlDump = file_get_contents($sqlDumpPath);
}

//Create fresh scheme+data (needs 'drop table if exists')
$mysqli = new mysqli(PHPUNIT_DBHOST, PHPUNIT_DBUSER, PHPUNIT_DBPASS, PHPUNIT_DBNAME);
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}
//Execute
$mysqli->multi_query($sqlDump);
//Close connection
$mysqli->close();
