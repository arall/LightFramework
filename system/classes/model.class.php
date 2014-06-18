<?php

/**
 * Model Class
 *
 * @package LightFramework\Core
 */
abstract class Model
{
    /**
     * Child class name
     * @var string
     */
    public static $className;

    /**
     * Data Base table name
     * @var string
     */
    public static $dbTable;

    /**
     * Current reserved vars
     * @var array
     */
    public static $reservedVars = array("className", "dbTable", "reservedVars", "reservedVarsChild", "idField");

    /**
     * Child reserved vars
     * @var array
     */
    public static $reservedVarsChild = array();

    /**
     * Data Base Table Id (primary & unique) Field
     * @var string
     */
    public static $idField = "";

    /**
     * Initial Funcion (to be inherited)
     */
    public function init() {}

    /**
     * Contructor.
     * @param multiple $id     Id of the object on the Data Base Table or Array of values to set
     * @param string   $prefix Field prefix to use multiple objetcs (forms/queries)
     */
    public function __construct($id="", $prefix="")
    {
        //Call the init
        $this->init();
        //Set the child class name
        $this->className = get_class($this);
        //Set the current Data Base Table name
        $this->dbTable = self::$dbTable;
        //Parent (self) reserved vars
        $this->reservedVars = self::$reservedVars;
        //Child reserved vars
        $this->reservedVarsChild = self::$reservedVarsChild;
        //Child id Field
        $this->idField = self::$idField;
        if (!$this->idField) {
            $this->idField = "id";
        }
        if ($id) {
            //Array of values to be setted
            if (is_array($id)) {
                $this->loadVarsArray($id, $prefix);
            //Id
            } else {
                $db = Registry::getDb();
                $rows = $db->query("SELECT * FROM `".$this->dbTable."` WHERE `".$this->idField."` = :id ",
                    array(
                        ":id" => $id
                    )
                );
                if (count($rows)) {
                    $vars = array_keys(get_class_vars($this->className));
                    foreach ($rows[0] as $name=>$value) {
                        if (in_array($name, $vars)) {
                            $this->$name = $value;
                        }
                    }
                }
            }
        }
    }

    /**
     * Validates DB update Insert (to be inherited)
     */
    public function validateInsert() {}
    /**
     * Runs before the DB Insert (to be inherited)
     */
    public function preInsert() {}
    /**
     * Runs after the DB Insert (to be inherited)
     */
    public function postInsert() {}

    /**
     * Validates DB update function (to be inherited)
     */
    public function validateUpdate() {}
    /**
     * Runs before the DB Update (to be inherited)
     */
    public function preUpdate() {}
    /**
     * Runs after the DB Update (to be inherited)
     */
    public function postUpdate() {}

    /**
     * Runs after the DB Delete (to be inherited)
     */
    public function validateDelete() {}
    /**
     * Runs after the DB Delete (to be inherited)
     */
    public function preDelete() {}
    /**
     * Runs after the DB Delete (to be inherited)
     */
    public function postDelete() {}

    /**
     * Set an array of values to current object (if the var exists on current object)
     *
     * @param array  $array  Array of values
     * @param string $prefix Prefix for the field (Optional).
     */
    public function loadVarsArray($array, $prefix="")
    {
        $vars = get_class_vars($this->className);
        foreach ($vars as  $name=>$value) {
            if(in_array($name, self::$reservedVars)) continue;
            if (!$prefix) {
                if (isset($array[$name])) {
                    $this->$name = ($array[$name]);
                }
            } else {
                //SQL Joins or Multiple object forms (prefix_field)
                if (isset($array[$prefix."_".$name])) {
                    $this->$name = ($array[$prefix."_".$name]);
                }
            }
        }
    }

    /**
     * Try to update the current object on Data Base
     *
     * @param  array $array Array of values to be setted (and replace the current object values).
     * @return bool
     */
    public function update($array = array())
    {
        $config = Registry::getConfig();
        $db = Registry::getDb();
        //Load Array
        if (is_array($array)) {
            self::loadVarsArray($array);
        }
        //Validate
        $err = $this->validateUpdate($array);
        if ($err) {
            return false;
        }
        //Pre Update
        $this->preUpdate($array);
        //Prepare SQL vars
        $idField = $this->idField;
        $set = array();
        $params = array();
        foreach (get_class_vars($this->className) as  $name=>$value) {
            if ($this->validateVar($name)) {
                $set[] = "`".$name."`"." = :".$name;
                $params[":".$name] = ($this->$name);
            }
            $params[":id"] = $this->$idField;
        }
        //SQL
        $res = $db->query("UPDATE `".$this->dbTable."` SET ".implode(" , ",$set)." WHERE `".$this->idField."`=:id", $params);
        if ($res) {
            //Post Update
            $this->postUpdate($array);

            return true;
        } else {
            if($config->get("debug"))
                Registry::addMessage($db->error, "error");
        }
    }

    /**
     * Try to insert the current object on Data Base
     *
     * @param  array $array Array of values to be setted (and replace the current object values).
     * @return bool
     */
    public function insert($array = array())
    {
        $config = Registry::getConfig();
        $db = Registry::getDb();
        //Load Array
        if (is_array($array)) {
            self::loadVarsArray($array);
        }
        //Validate
        $err = $this->validateInsert($array);
        if ($err) {
            return false;
        }
        //Pre Insert
        $this->preInsert();
        $values1 = array();
        $values2 = array();
        $params = array();
         //Prepare SQL vars
        foreach (get_class_vars($this->className) as $name=>$value) {
            if ($this->validateVar($name)) {
                $values1[] = "`".$name."`";
                $values2[] = ":".$name;
                $params[":".$name] = $this->$name;
            }
        }
        //SQL
        $res = $db->query("INSERT INTO `".$this->dbTable."` (".implode(" , ",$values1).") VALUES (".implode(" , ",$values2).")", $params);
        if ($res) {
            $idField = $this->idField;
            $this->$idField = $db->lastInsertId();
            //Post Insert
            $this->postInsert($array);

            return true;
        } else {
            if($config->get("debug"))
                Registry::addMessage($db->error, "error");
        }
    }

    /**
     * Try to delete the current object on Data Base
     *
     * @return bool
     */
    public function delete()
    {
        $db = Registry::getDb();
        $config = Registry::getConfig();
        //Validate
        $err = $this->validateDelete();
        if ($err) {
            return false;
        }
        //Pre Delete
        $this->preDelete($array);
        //Delete
        $idField = $this->idField;
        $res = $db->query("DELETE FROM `".$this->dbTable."` WHERE `".$this->idField."` = :id ",
            array(
                ":id" => $this->$idField
            )
        );
        if ($res) {
            //Post Insert
            $this->postDelete($array);

            return true;
        } else {
            if($config->get("debug"))
                Registry::addMessage($db->error, "error");
        }
    }

    /**
     * Validates if a variable is able to set
     *
     * @param  string $varName Variable Name
     * @return bool
     */
    private function validateVar($varName = "")
    {
        if ($varName == $this->idField) {
            return false;
        }
        if (in_array($varName,$this->reservedVars)) {
            return false;
        }
        if (in_array($varName, $this->reservedVarsChild)) {
            return false;
        }
        if (isset($this->$varName)) {
            return true;
        }
    }
}
