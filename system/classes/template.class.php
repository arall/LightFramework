<?php
class Template {

	var $name = "";
	
	function __construct(){
		$config = Registry::getConfig();
		$this->name = $config->get("template");
	}

	//Loads a view/module
    public static function loadTemplate($template, $vars = array()){
		$templatePath = $template.'.php';
	    if(!file_exists($templatePath)){
	    	die("File not found: ".$templatePath);
	    }
	    return self::loadTemplateFile($templatePath, $vars);
    }

    public static function renderTemplate($template, $vars = array()){
    	echo self::loadTemplate($template, $vars);
    }

    private static function loadTemplateFile($__ct___templatePath__, $__ct___vars__){
		if(is_array($__ct___vars__)){
			extract($__ct___vars__, EXTR_OVERWRITE);
		}
    	$__ct___template_return = '';
		ob_start();
    	require($__ct___templatePath__);
    	$__ct___template_return = ob_get_contents();
    	ob_end_clean();
    	return $__ct___template_return;
    }
} 
?>