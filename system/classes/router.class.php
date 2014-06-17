<?php

/**
 * Router Class
 *
 * @package LightFramework\Core
 */
class Router
{
    /**
     * Load the correct App and launch an App Action
     */
    public static function delegate()
    {
        //Get the current Config
        $config = Registry::getConfig();
        if ($config->get("debug")) {
            Registry::setDebug("started", microtime(true));
        }
        //Get the current Url
        $url = Registry::getUrl();
        //Load App
        $app = self::getAppPath($url->app, $url->router);
        //Route
        self::route($app, $url->action);
    }

    /**
     * Get the App path.
     *
     * @param  string $appName App name
     * @param  string $router  Router name
     * @return string
     */
    public static function getAppPath($appName, $router="")
    {
        //Get the current Config
        $config = Registry::getConfig();
        //Load App
        return $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$router.DIRECTORY_SEPARATOR.$appName.DIRECTORY_SEPARATOR.$appName.".php";
    }

    /**
     * Route
     * @param  string $appPath App path
     * @param  string $action  Action
     * @return void
     */
    private static function route($appPath, $action="index")
    {
        //Appname
        $appName = current(explode(".", end(explode(DIRECTORY_SEPARATOR, $appPath))));
        //Securize
        $appPath = str_replace("..", "", $appPath);
        //Check if the app path exists
        if (is_readable($appPath)==false) {
            //Show error
            Error::render("App not found: ".$appPath);
        } else {
            //Load the App
            include_once($appPath);
            //Check if its a Controller/Controller Router
            $controllerClass = $appName."Controller";
            $controllerRouterClass = $appName."ControllerRouter";
            //Class exist?
            if (class_exists($controllerClass)) {
                $class = $controllerClass;
            } elseif (class_exists($controllerRouterClass)) {
                $class = $controllerRouterClass;
            } else {
                //Show error
                Error::render("Acction not found: ".$action);
            }
            //Launch
            self::launch($class, $appName, $action);
        }
    }

    /**
     * Launch the controller action.
     *
     * @param  string $class   Controller class name
     * @param  string $appName Controller name
     * @param  string $action  Action name
     * @return void
     */
    public function launch($class, $appName, $action="index")
    {
        //Get the current Url
        $url = Registry::getUrl();
        //Class exist?
        if (class_exists($class)) {
            //Init
            $controller = new $class();
            //Check if the acction exists
            if (method_exists($controller, $action)) {
                //Router?
                if ($url->router) {
                    //Load the App
                    $path = self::getAppPath($url->router);
                    $router = $url->router."ControllerRouter";
                    include_once($path);
                    //Init
                    new $router();
                }
                //Launch the App Action
                $controller->$action();
                //Preserve Current Debug
                Registry::preserveDebug();
            //Controller Router?
            } elseif (strpos($class, "ControllerRouter")) {
                //New App Path
                $appPath = self::getAppPath($action, $appName);
                //Set new URL
                $url->router = $appName;
                $url->app = $action;
                $url->action = $url->vars[0] ? $url->vars[0] : "index";
                @array_shift($url->vars);
                Registry::setUrl($url);
                //Route
                self::route($appPath, $url->action);
            } else {
                //Show error
                Error::render("Acction not found: ".$action);
            }
        }
    }
}
