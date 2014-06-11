<?php

/**
 * Url Class
 *
 * @package LightFramework\Core
 */
class Url
{
    /**
     * Current Url
     * @var string
     */
    public $url;

    /**
     * Current App name
     * @var string
     */
    public $app;

    /**
     * Current Action name
     * @var string
     */
    public $action;

    /**
     * Url extra GET vars
     * @var array
     */
    public $vars;

    /**
     * Contructor
     */
    public function __construct()
    {
        $this->build($_SERVER['REQUEST_URI']);
    }

    /**
     * URL Builder
     *
     * @param  string $uri URL URI
     * @return void
     */
    public function build($uri)
    {
        //Get the current config
        $config = Registry::getConfig();
        //Fix extra slashes
        $dir = $config->get("dir");
        if ($dir == "/") {
            $dir = "";
        }
        //Read URL
        $url = trim(str_replace("//", "/", str_replace($dir, "", $uri)), "/");
        //Exclude GET params
        if (strstr($url, "?")) {
            $url = substr($url, 0, strpos($url, "?"));
        } elseif (strstr($url, "&")) {
            $url = substr($url, 0, strpos($url, "&"));
        }
        //Set Url
        $this->url = $url;
        //Set Default App
        $this->app = $config->get("defaultApp");
        //Set Default Action
        $this->action = "index";
        //URL contruction
        if ($url) {
            //Read Vars
            $vars = explode("/", $url);
            $this->app = $vars[0];
            if ($vars[1]) {
                $this->action = $vars[1];
            }
            //GET Vars
            if (count($vars)>2) {
                for ($i = 2; $i < count($vars); $i++) {
                    $this->vars[$i-2] = $vars[$i];
                }
            }
        }
        //POST is mandatory
        if ($_POST['app']) {
            $this->app = $_POST['app'];
        }
        if ($_POST['action']) {
            $this->action = $_POST['action'];
        }
    }

    /**
     * Gets the full site Url
     *
     * @param  string $path Extra Url
     * @return string Url
     */
    public static function site($path="")
    {
        $config = Registry::getConfig();
        $url = trim($config->get('url'), "/");
        $path = trim($path, "/");

        return $url."/".$path;
    }

    /**
     * Gets the curren template Url
     *
     * @param  string $path Extra Url
     * @return string Url
     */
    public static function template($path="")
    {
        $config = Registry::getConfig();
        $template = Registry::getTemplate();
        $url = trim($config->get('url'), "/");
        $path = trim($path, "/");

        return $url."/templates/".$template->name."/".$path;
    }
}
