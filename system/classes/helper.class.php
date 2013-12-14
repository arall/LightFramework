<?php
/**
 * Helper Class
 *
 * @package LightFramework\Core
 */
class Helper{

    /**
     * Converts a date to human readable
     * 
     * @param  string $date Non-human readable date
     * @return string Human readable date
     */
    public function humanDate($date=""){
        if($date && $date!="0000-00-00 00:00:00"){
            return date("H:i:s d/m/Y", strtotime($date));
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
