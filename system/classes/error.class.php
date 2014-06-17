<?php

/**
 * Error Class
 *
 * @package LightFramework\Core
 */
class Error
{
    /**
     * Shows an error
     *
     * @param  string $message Error String to show
     * @return void
     */
    public static function render($message="")
    {
        //Get the current Config
        $config = Registry::getConfig();
        //Debug Enabled?
        if($config->get("debug"))
            Template::render("error", array("content" => $message));
        else
            redirect(Url::site());
    }
}
