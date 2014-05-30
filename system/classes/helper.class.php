<?php
/**
 * Helper Class
 *
 * @package LightFramework\Core
 */
class Helper
{
    /**
     * Make a sortable link for a table in a form
     *
     * @param  string $field Database Field
     * @param  string $text  Text
     * @return string HTML Link
     */
    public function sortableLink($field="", $text="")
    {
        $order = $field;
        $orderDir = "ASC";
        if ($_REQUEST['order']==$field) {
             $cssClass = "sort-by-attributes-alt";
            if ($_REQUEST['orderDir']=="ASC") {
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
     * Make a sort inputs.
     *
     * @return string HTML form inputs
     */
    public function sortInputs()
    {
        return "<input type='hidden' name='order' value='".Helper::sanitize($_REQUEST["order"])."'>
            <input type='hidden' name='orderDir' value='".Helper::sanitize($_REQUEST["orderDir"])."'>";
    }

    /**
     * Make a pagination form inputs.
     *
     * @return string HTML inputs
     */
    public function paginationInputs()
    {
        return "<input type='hidden' name='limit' value='".Helper::sanitize($_REQUEST["limit"])."'>
            <input type='hidden' name='limitStart' value='".Helper::sanitize($_REQUEST["limitStart"])."'>";
    }

    /**
     * Sanitizes an string to be printed in a HTML view
     *
     * @param  string $string String to be sanitized
     * @return string Sanitized string
     */
    public function sanitize($string)
    {
        return htmlspecialchars($string, ENT_QUOTES);
    }

    /**
     * Returns a HTML formated Debug Message
     *
     * @param  string $string Debug Message
     * @return string HTML formated Message
     */
    public function printDebugMessage($string="")
    {
        if (is_array($string) || is_object($string)) {
            return "<pre>".Helper::sanitize(print_r($string, true))."</pre>";
        } else {
            return Helper::sanitize($string);
        }
    }

    /**
     * Returns all allowed vars (db fields) of an object
     *
     * @param  string $className Class name
     * @return array  Array of allowed fields (vars)
     */
    public function getClassFields($className)
    {
        $fields = array();
        $vars = get_class_vars($className);
        foreach ($vars as  $name=>$value) {
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
    public function humanDate($date="")
    {
        if ($date && $date!="0000-00-00 00:00:00" && $date!="00:00:00" && $date!="0000-00-00") {
             if (strlen($date)>8) {
                 if (strlen($date)>10) {
                    return date("H:i:s d/m/Y", strtotime($date));
                } else {
                    return date("d/m/Y", strtotime($date));
                }
            } else {
                return date("H:i:s", strtotime($date));
            }
        } else {
            return "-";
        }
    }

    /**
     * Converts bytes to human readable size
     * @param  integer $bytes     Bytes
     * @param  integer $precision Precision
     * @return string  Human readable size
     */
    public function formatBytes($bytes, $precision=2)
    {
        $base = @log($bytes) / log(1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) ." ". $suffixes[floor($base)];
    }
}
