<?php

/**
 * Template Class
 *
 * @package LightFramework\Core
 */
class Template
{
    /**
     * Template name (same as folder name)
     * @var string
     */
    public $name = "";

    /**
     * Constructor
     */
    public function __construct()
    {
        //Get the current Config
        $config = Registry::getConfig();
        //Set the template name
        $this->name = $config->get("template");
    }

    /**
     * Try to load a View/Module
     *
     * @param  string $file File name
     * @param  array  $vars List of values to pass trought
     * @return string HTML
     */
    public static function loadTemplate($file, $vars = array())
    {
        //Check if file exists
        $filePath = $file.'.php';
        if (!file_exists($filePath)) {
            //Show error
            Error::render("File not found: ".$filePath);
        }

        return self::loadTemplateFile($filePath, $vars);
    }

    /**
     * Load a View/Module
     * @param  multiple $path File or files to load
     * @param  array    $vars List of values to pass trought
     * @return string   HTML
     */
    private static function loadTemplateFile($path, $vars)
    {
        if (is_array($vars)) {
            extract($vars, EXTR_OVERWRITE);
        }
        $return = '';
        ob_start();
        require($path);
        $return = ob_get_contents();
        ob_end_clean();

        return $return;
    }

    /**
     * Prints the HTML string passed by param on the current Template
     *
     * @param string $layer Template layer (index.layer.php by default)
     * @param array  $vars  List of values to pass trought
     */
    public static function render($layer="index", $vars=array())
    {
        $template = Registry::getTemplate();
        $config = Registry::getConfig();
        $path = $config->get("path").DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$template->name.
            DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $layer).".layer";
        $html = self::loadTemplate($path, $vars);
        echo $html;
    }

    /**
     * Render a Email Template
     * @param  string $view     Email View
     * @param  array  $vars     List of values to pass trought
     * @param  string $template Template to be used
     * @return string HTML
     */
    public static function renderEmail($view, $vars=array(), $template="")
    {
        $config = Registry::getConfig();
        $originalTemplate = "";
        if ($template) {
            $originalTemplate = $config->get("template");
            $config->set("template", $template);
        }
        $path = $config->get("path").DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$template.DIRECTORY_SEPARATOR."emails";
        $content = Template::loadTemplateFile($path.DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR.$view.".view.php", $vars);
        $render = Template::loadTemplateFile($path.DIRECTORY_SEPARATOR."index.layer.php", array("content" => $content));
        if ($template) {
            $config->set("template", $originalTemplate);
        }

        return utf8_decode($render);
    }
}
