<?php

/**
 * Better print_r
 *
 * @param  array  $array  Array to print
 * @param  boolean $return Return or print
 * @return string
 */
function print_pre($array=array(), $return=false)
{
    $out = "<pre>";
    $out .= print_r($array, true);
    $out .= "</pre>";
    if ($return) {
        return $out;
    } else {
        echo $out;
    }
}

/**
 * Redirect
 *
 * @param  string $url     Url to redirect
 * @param  string $message Message
 * @param  string $type    Message
 * @return void
 */
function redirect($url="", $message="", $type="")
{
    if ($message) {
        Registry::addMessage($message, $type);
    }
    header("Location: ".$url);
    die();
}
