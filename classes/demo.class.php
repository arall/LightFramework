<?php
class Demo extends Model
{
    public $id;
    public $userId;
    public $string;
    public $dateInsert;
    public $dateUpdate;

    public function init()
    {
        parent::$dbTable = "demos";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function validateInsert()
    {
        //Ajax Debug Message Example
        Registry::addDebugMessage("Starting Insert validation");
        Registry::addDebugMessage($this);
        //Empty string?
        if (!$this->string) {
            Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_EMPTY"), "error", "string");
        //Already exising?
        } elseif ($this->getDemoByString($this->string)) {
            Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_TAKEN"), "error", "string");
        }
        //Return messages avoiding deletion
        return Registry::getMessages(true);
    }

    public function preInsert()
    {
        $user = Registry::getUser();
        $this->userId = $user->id;
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    public function validateUpdate()
    {
        //Ajax Debug Message Example
        Registry::addDebugMessage("Starting Update validation");
        Registry::addDebugMessage($this);
        //Empty string?
        if (!$this->string) {
            Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_EMPTY"), "error", "string");
        //Already exising?
        } elseif ($this->getDemoByString($this->string, $this->id)) {
            Registry::addMessage(Registry::translate("MODL_DEMO_VALIDATE_STRING_TAKEN"), "error", "string");
        }
        //Return messages avoiding deletion
        return Registry::getMessages(true);
    }

    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public function getDemoByString($string="", $ignoreId=0)
    {
        $db = Registry::getDb();
        $query = "SELECT * FROM `demos` WHERE `string`!='".mysql_real_escape_string($string)."'";
        if ($ignoreId) {
            $query .= " AND `id`!=".(int) $ignoreId;
        }
        if ($db->Query($query)) {
            if ($db->getNumRows()) {
                $row = $db->fetcharray();

                return new Demo($row);
            }
        }
    }

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();

        //Select field builder
        $tables = array(
            //Demo
            "demo" => Helper::getClassFields("Demo"),
            //User
            "user" => Helper::getClassFields("User"),
        );
        foreach ($tables as $table=>$fields) {
            foreach ($fields as $field) {
                $selects[] = "`".$table."`.`".$field."` as `".$table."_".$field."`";
            }
        }
        $select = implode(", ", $selects);

        //Query
        $query = "SELECT ".$select."
        FROM `demos` as `demo`
            LEFT JOIN `users` as `user` ON `user`.`id`=`demo`.`userId`
        WHERE 1=1 ";
        //Total
        if ($db->Query($query)) {
            $total = $db->getNumRows();
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                $tmp = explode(".", $data['order']);
                if (@in_array($tmp[1], $tables[$tmp[0]]) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY ".mysql_real_escape_string("`".$tmp[0]."`.`".$tmp[1]."`")." ".mysql_real_escape_string($data['orderDir']);
                }
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            if ($total) {
                if ($db->Query($query)) {
                    if ($db->getNumRows()) {
                        $rows = $db->loadArrayList();
                        foreach ($rows as $row) {
                            $results[] = array(
                                "demo" => new Demo($row, "demo"),
                                "user" => new User($row, "user")
                            );
                        }

                        return $results;
                    }
                }
            }
        }
    }
}
