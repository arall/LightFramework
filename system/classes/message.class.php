<?php

/**
 * Message Class
 *
 * @package LightFramework\Core
 */
class Message
{
    /**
     * Message itself
     * @var string
     */
    public $message;

    /**
     * Type of message [notice, success, warning, error]
     * @var string
     */
    public $type;

    /**
     * Related form field
     * @var string
     */
    public $field;

    /**
     * Redirection URL
     * @var string
     */
    public $url;

    /**
     * Contructor
     *
     * @param string $message
     * @param string $type
     * @param string $field
     * @param string $url
     */
    public function __construct($message="", $type="notice", $field="", $url="")
    {
        $this->message = $message;
        $this->type = strtolower($type);
        $this->field = $field;
        $this->url = $url;
    }

    /**
     * Fix for Bootstrap 3 Alert CSS's vs Form CSS's.
     *
     * @return string CSS Class name
     */
    public function getAlertType()
    {
        if ($this->type=="error") {
            return "danger";
        } else {
            return $this->type;
        }
    }
}
