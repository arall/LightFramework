<?php

/**
 * Demo Class
 *
 * @package LightFramework\Demo
 */
class Demo extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;

    /**
     * User owner
     * @var int
     */
    public $userId;

    /**
     * Demo string
     * @var string
     */
    public $string;

    /**
     * Insert date
     * @var string
     */
    public $dateInsert;

    /**
     * Update date
     * @var string
     */
    public $dateUpdate;

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "demos";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Insert and Update validation
     * In this case, its the same for both methods
     *
     * @return bool
     */
    private function validate()
    {
        //Empty string?
        if (!$this->string) {
            Registry::addMessage(Language::translate("MODL_DEMO_VALIDATE_STRING_EMPTY"), "error", "string");
        //Already exising?
        } elseif ($this->getDemoByString($this->string, $this->id)) {
            Registry::addMessage(Language::translate("MODL_DEMO_VALIDATE_STRING_TAKEN"), "error", "string");
        }
        //Return messages avoiding deletion
        return Registry::getMessages(true);
    }

    /**
     * Insert validation
     *
     * @return array Object Messages
     */
    public function validateInsert()
    {
        //Ajax Debug Message Example
        Registry::addDebugMessage("Starting Insert validation");
        Registry::addDebugMessage($this);
        //Validation
        return $this->validate();
    }

    /**
     * Pre-Insert actions
     *
     * Ownser user (current)
     * Creation date
     *
     * @return void
     */
    public function preInsert()
    {
        $user = Registry::getUser();
        $this->userId = $user->id;
        $this->dateInsert = date("Y-m-d H:i:s");
    }

    /**
     * Update validation
     *
     * @return array Object Messages
     */
    public function validateUpdate()
    {
        //Ajax Debug Message Example
        Registry::addDebugMessage("Starting Update validation");
        Registry::addDebugMessage($this);
        //Validation
        return $this->validate();
    }

    /**
     * Pre-Update actions
     *
     * Update date
     *
     * @return void
     */
    public function preUpdate()
    {
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    /**
     * Get a Demo by string
     *
     * @param string  $string   String to search
     * @param integer $ignoreId User id to be ignored (optional)
     *
     * @return bool|object Demo
     */
    public static function getDemoByString($string="", $ignoreId=0)
    {
        $db = Registry::getDb();
        $params = array();
        $query = "SELECT * FROM `demos` WHERE string = :string";
        $params[":string"] = $string;
        //Ignore Id
        if ($ignoreId) {
            $params[":ignoreId"] = $ignoreId;
            $query .= " AND `id` != :ignoreId";
        }
        $rows = $db->query($query, $params);
        if ($rows) {
            return new Demo($rows[0]);
        }
    }

    /**
     * Object selection (multiple)
     *
     * @param array   $data       Conditionals and Order values
     * @param integer $limit      Limit
     * @param integer $limitStart Limit start
     * @param int     $total      Total rows found
     *
     * @return array Array ob Demo and User objects
     */
    public static function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Select field builder
        $tables = array(
            //Demo
            "demo" => Helper::getClassFields("Demo"),
            //User
            "user" => Helper::getClassFields("User"),
        );
        $selects = array();
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

        //Where
        $params = array();

        //Total
        $total = count($db->Query($query, $params));
        if ($total) {
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                $tmp = explode(".", $data['order']);
                if (@in_array($tmp[1], $tables[$tmp[0]]) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".$tmp[0]."`.`".$tmp[1]."` ".$data['orderDir'];
                }
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query, $params);
            if (count($rows)) {
                $results = array();
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
