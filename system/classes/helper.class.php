<?php
/**
 * Helper Class
 *
 * @package LightFramework\Core
 */
class Helper{

    /**
     * Make a sortable link for a table in a form
     *
     * @param  string $field Database Field
     * @param  string $text  Text
     * @return string HTML Link
     */
    public function sortableLink($field="", $text=""){
        $order = $field;
        $orderDir = "ASC";
        if($_REQUEST['order']==$field){
             $cssClass = "sort-by-attributes-alt";
            if($_REQUEST['orderDir']=="ASC"){
                $orderDir = "DESC";
                $cssClass = "sort-by-attributes";
            }
        }
        return
            "<a href='#' class='sortable' data-order='".Helper::sanitize($order)."' data-orderDir='".Helper::sanitize($orderDir)."'>
                ".Helper::sanitize($text)."
                <span class='glyphicon glyphicon-".Helper::sanitize($cssClass)."'></span>
            </a>";
    }

    /**
     * Sanitizes an string to be printed in a HTML view
     *
     * @param  string $string String to be sanitized
     * @return string Sanitized string
     */
    public function sanitize($string){
        return htmlspecialchars($string, ENT_QUOTES);
    }

    /**
     * Returns a HTML formated Debug Message
     *
     * @param  string $string Debug Message
     * @return string HTML formated Message
     */
    public function printDebugMessage($string=""){
        if(is_array($string) || is_object($string)){
            return "<pre>".Helper::sanitize(print_r($string, true))."</pre>";
        }else{
            return Helper::sanitize($string);
        }
    }

    /**
     * Returns all allowed vars (db fields) of an object
     *
     * @param  string $className Class name
     * @return array  Array of allowed fields (vars)
     */
    public function getClassFields($className){
        $fields = array();
        $vars = get_class_vars($className);
        foreach($vars as  $name=>$value){
            if(in_array($name, $className::$reservedVars) || in_array($name, $className::$reservedVarsChild)) continue;
            $fields[] = $name;
        }
        return $fields;
    }

    /**
     * Converts a date to human readable
     * 
     * @param  string $date Non-human readable date
     * @return string Human readable date
     */
    public function humanDate($date=""){
        if($date && $date!="0000-00-00 00:00:00" && $date!="00:00:00" && $date!="0000-00-00"){
             if(strlen($date)>8){
				 if(strlen($date)>10){
					return date("H:i:s d/m/Y", strtotime($date));
				}else{
					return date("d/m/Y", strtotime($date));
				}
			}else{
				return date("H:i:s", strtotime($date));
			}
        }else{
            return "-";
        }
    }

    /**
     * Converts bytes to human readable size
     * @param  integer $bytes     Bytes
     * @param  integer $precision Precision
     * @return string  Human readable size
     */
    public function formatBytes($bytes, $precision=2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        return number_format(round($bytes, $precision), 2, ",", ".") . ' ' . $units[$pow]; 
    }
} 
