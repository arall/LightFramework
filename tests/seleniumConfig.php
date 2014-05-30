<?php

class seleniumConfig
{

    //Urls / Paths
    public $folder = '/var/www/';
    public $host = 'http://localhost';
    public $path = '/LightFramework/';
    //Screenshot
    public $captureScreenshotOnFailure = true;
    public $screenShotPath = 'tests/system/screenshots';
    //Browser
    public $browser = 'firefox';
    public $cache = 'off';
    public $windowSize = array(1280, 1024);
}
