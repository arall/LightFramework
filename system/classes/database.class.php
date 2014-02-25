<?php
/**
 * Config Class
 *
 * @package LightFramework\Core
 */
class Database extends PDO{

    /**
     * Current Query
     *
     * @var string
     */
    public $query;

    /**
     * Current result
     *
     * @var resource
     */
    public $result;

    /**
     * Current connection
     *
     * @var resource
     */
    public $link;

    /**
     * Constructor
     * Tries to connecto to DB.
     *
     * @param string $server   DB server adress
     * @param string $host     DB user
     * @param string $pass     DB user password
     * @param string $database DB name
     *
     * @return bool
     */
    public function __construct($host="localhost", $user="", $pass="", $database="") {
        if(!function_exists("mysql_connect"))
            return false;
        $this->link = mysql_connect($host, $user, $pass, true) or die("Error: Cannot connect to host: ".$host);
        mysql_select_db($database) or die("Error: Cannot read the database: ".$database);
        $this->mysql_set_charset("utf8");
        $opened = true;
        return $opened;
    }

    /**
     * Set a charset on DB connection
     * @param  string $charset Charset
     * @return bool
     */
    public function mysql_set_charset($charset="utf8"){
        return $this->query("SET character_set_results='$charset',character_set_client='$charset',character_set_connection='$charset',character_set_database='$charset',character_set_server='$charset'");
    }

    /**
     * Closes the current connection
     *
     * @return bool
     */
    public function close() {
        if(!function_exists("mysql_close"))
            return false;
        mysql_close($this->link);
        return true;
    }

    /**
     * Execute the passed query on the current connection
     *
     * @param string $query
     *
     * @return bool
     */
    public function query($query){
        $config = Registry::getConfig();
        //Debug
        if($config->get("debug")){
            //Save the previous stored time
            $sqlTime = Registry::getDebug("sqlTime");
            //Save the previous queries
            $stored = Registry::getDebug("queries");
            //Current Query starting time
            $msc = microtime(true);
        }
        $this->query = $query;
        $this->result = mysql_query($query, $this->link);
        //Debug
        if($config->get("debug")){
            //Error?
            if(!$this->result){
                Registry::setDebug("sqlError", true);
                //SQL Error
                $error = $this->getError();
                //Backtrace
                ob_start();
                debug_print_backtrace();
                $trace = ob_get_contents();
                ob_end_clean();
            }
            //Current Query total execution time
            $msc = round(((microtime(true)-$msc)*1000), 2);
            //Save info as debug log
            $stored[] = array(
                "query" => $query,
                "time" => $msc,
                "result" => $this->result,
                "error" => $error,
                "trace" => $trace,
            );
            Registry::setDebug("queries", $stored);
            //Increase previous stored time
            Registry::setDebug("sqlTime", (int)$sqlTime += $msc);
        }
        return $this->result;
    }

    public function fetcharray($result=null){
        if(!$result)
            $result = $this->result;
        return @mysql_fetch_array($result);
    }

    public function loadArrayList($result=null){
        while($row = $this->fetchassoc($result)){
            $array[] = $row;
        }
        return $array;
    }

    public function fetchrow($result=null){
        if(!$result)
            $result = $this->result;
        return mysql_fetch_row($result);
    }

    public function fetchassoc($result=null){
        if(!$result)
            $result = $this->result;
        return mysql_fetch_assoc($result);
    }

    public function getNumRows($result=null){
        if(!$result)
            $result = $this->result;
        return mysql_num_rows($result);
    }

    public function freeresult($result=null){
        if(!$result)
            $result = $this->result;
        return mysql_free_result($result);
    }

    public function lastid(){
        return mysql_insert_id($this->link);
    }

    public function getError($link=null){
        if(!$link)
            $link = $this->link;
        return mysql_errno($link).": ".mysql_error($link);
    }

    public function __destruct(){
        $this->close();
        unset($this);
    }
}
