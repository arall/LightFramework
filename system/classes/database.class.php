<?php

/**
 * Config Class
 *
 * @package LightFramework\Core
 */
class Database
{
    /**
     * Current PDO object
     *
     * @var object
     */
    public $pdo;

    /**
     * Current PDO statement object
     *
     * @var object
     */
    public $prepared;

    /**
     * Current error
     *
     * @var string
     */
    public $error;

    /**
     * Constructor
     * Tries to connecto to DB.
     *
     * @param string $server   DB server adress
     * @param string $host     DB user
     * @param string $pass     DB user password
     * @param string $database DB name
     * @param string $charset  DB Charset
     *
     * @return bool
     */
    public function __construct($host="localhost", $user="", $pass="", $database="", $charset="")
    {
        $dsn = "mysql:host=".$host.";dbname=".$database.";";
        if ($charset) {
            $dsn .= "charset=".$charset;
        }
        try {
            $this->pdo = new PDO($dsn, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            //Show error
            Error::render("Database error: ".$e->getMessage());
        }
    }

    public function query($query, $params=null, $fetchmode=PDO::FETCH_ASSOC)
    {
        $this->error = null;
        $config = Registry::getConfig();
        //Debug
        if ($config->get("debug")) {
            //Save the previous stored time
            $sqlTime = Registry::getDebug("sqlTime");
            //Save the previous queries
            $stored = Registry::getDebug("queries");
            //Current Query starting time
            $msc = microtime(true);
        }
        try {
            //Prepare the query
            $this->prepared = $this->pdo->prepare($query);
            //Bind Params
            if (count($params)) {
                foreach ($params as $var=>&$value) {
                    //Bind
                    $this->prepared->bindParam($var, $value);
                    //Debug
                    if ($config->get("debug")) {
                        //Debug Printable
                        $query = str_replace($var, "'".$value."'", $query);
                    }
                }
            }
            //Execute the statment
            $this->prepared->execute();
            $statement = strtolower(substr($query, 0 , 6));
            if ($statement==='select') {
                $result =  $this->prepared->fetchAll($fetchmode);
            } elseif ($statement==='insert' ||  $statement==='update' || $statement==='delete') {
                $result = $this->prepared->rowCount();
            } else {
                $result = NULL;
            }
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
        //Debug
        if ($config->get("debug")) {
            //Error?
            if ($this->error) {
                Registry::setDebug("sqlError", true);
                //SQL Error
                $error = $this->error;
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
            Registry::setDebug("sqlTime", (int) $sqlTime += $msc);
        }

        return $result;
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
}
