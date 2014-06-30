<?php

/**
 * Language Class
 *
 * @package LightFramework\Core
 */
class Language
{
    /**
     * All the available llangauges
     * @var array
     */
    private static $languages = array();

    /**
     * All the strings of the current language
     * @var array
     */
    private static $strings = array();

    /**
     * Constructor
     * Loads the default lang strings
     * It will detect any language change by URL
     */
    public function __construct()
    {
        session_start();
        //Get current langs
        self::$languages = self::getLanguages();
        $lang = "";
        //Detect lang change
        if ($_REQUEST['lang'] && in_array($_REQUEST['lang'], self::$languages)) {
            $lang = $_REQUEST['lang'];
        }
        if (!$lang) {
            if (!$_SESSION['lang']) {
                $config = Registry::getConfig();
                $lang = $config->get("defaultLang");
            } else {
                $lang = $_SESSION['lang'];
            }
        }
        if ($lang) {
            $lang = preg_replace('/[^a-zA-Z0-9_]/','', $lang);
            $_SESSION['lang'] = $lang;
            self::$strings = self::load("languages/".$lang.".ini");
        }
    }

    /**
     * Loads a lang file
     *
     * @param  string $path File path
     * @return array  Translation Strings
     */
    public function load($path)
    {
        if (file_exists($path)) {
            $contents = file_get_contents($path);
            $strings = @parse_ini_string($contents);

            return $strings;
        }
    }

    /**
     * Translate a string
     *
     * @param  string $string String to translate
     * @return string Translated string
     */
    public function translate($string="")
    {
        $res = self::$strings[strtoupper($string)];
        if (!$res) {
            return $string;
        } else {
            return $res;
        }
    }

    /**
     * Get current avariable languages
     *
     * @return array Languages
     */
    public function getLanguages()
    {
        $languages = array();
        $path = "languages/";
        if (file_exists($path)) {
            $langFiles = scandir($path);
            if (count($langFiles)) {
                foreach ($langFiles as $langFile) {
                    $tmp = explode(".", $langFile);
                    if ($tmp[0]) {
                        $languages[] = $tmp[0];
                    }
                }
            }
        }

        return $languages;
    }
}
