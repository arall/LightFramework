<?php
class Helper{

    public function humanDate($date=""){
        if($date && $date!="0000-00-00 00:00:00"){
            return date("H:i:s d/m/Y", strtotime($date));
        }else{
            return "-";
        }
    }

    public function formatBytes($bytes, $precision=2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        return number_format(round($bytes, $precision), 2, ",", ".") . ' ' . $units[$pow]; 
    }
} 
?>