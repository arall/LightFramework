<?php
class Language{

    static private $languages = array();
	static private $strings = array();
	
    public function __construct(){
        session_start();
        //Get current langs
        $langFiles = scandir("languages/");
        if(count($langFiles)){
            foreach($langFiles as $langFile){
                $tmp = explode(".", $langFile);
                if($tmp[0]){
                    self::$languages[] = $tmp[0];
                }
            }
        }
        //Detect lang change
        if($_REQUEST['lang'] && in_array($_REQUEST['lang'], self::$languages)){
            $lang = $_REQUEST['lang'];
        }
        if(!$lang){
            if(!$_SESSION['lang']){
                $config = Registry::getConfig();
                $lang = $config->get("defaultLang");
            }else{
                $lang = $_SESSION['lang'];
            }
        }
        if($lang){
            $lang = preg_replace('/[^a-zA-Z0-9_]/','', $lang);
            $_SESSION['lang'] = $lang;
    	    self::$strings = self::load("languages/".$lang.".ini");
        }
    }
	
    public function load($path){
        if(file_exists($path)){
            $contents = file_get_contents($path);
            $strings = @parse_ini_string($contents);
            return $strings;
        }
    }
    
    public function translate($string=""){
	    $res = self::$strings[$string];
        if(!$res){
            return $string;
        }else{
            return $res;
        }
    }
} 
?>