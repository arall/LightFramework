<?php

/**
 * Config Class
 *
 * @package LightFramework\Core
 */
class Config
{
    /**
     * Array of stored values
     *
     * @var array
     */
    private $data;

    /**
     * Default constructor
     *
     * @param array $vars
     */
    public function __construct($vars=array())
    {
        if (is_array($vars)) {
            $this->setByArray($vars);
        }
    }

    /**
     * Set a value into self data array
     *
     * @param string $name
     * @param mixed  $value
     */
    public function set($name, $value)
    {
        $this->data[$name] = $value;
    }

    /**
     * Get a value previously stored in self data array
     *
     * @param mixed $name
     */
    public function get($name)
    {
        return $this->data[$name];
    }

    /**
     * Set all the values inside the array in self data array
     *
     * @param array $array
     */
    public function setByArray($array)
    {
        if (is_array($array)) {
            if (count($array)) {
                foreach ($array as $name=>$value) {
                    $this->set($name,$value);
                }
            }
        }
    }
}
