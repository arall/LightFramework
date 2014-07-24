<?php

/**
 * User Class
 *
 * @package LightFramework\Core
 */
class User extends Model
{
    /**
     * Id
     * @var int
     */
    public $id;

    /**
     * Status Id
     * @var int
     */
    public $statusId;

    /**
     * Role Id
     * @var int
     */
    public $roleId;

    /**
     * Email
     * @var string
     */
    public $email;

    /**
     * Username
     * @var string
     */
    public $username;

    /**
     * Password
     * @var string
     */
    public $password;

    /**
     * Cookie Token
     * @var string
     */
    public $token;

    /**
     * Recovery Hash
     * @var string
     */
    public $recoveryHash;

    /**
     * Language code
     * @var string
     */
    public $language;

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
     * Last visit date
     * @var string
     */
    public $lastvisitDate;

    /**
     * Status CSS classes
     * @var array
     */
    public $statusesCss = array(
        0 => "danger",
        1 => "success",
    );

    /**
     * Status types
     * @var array
     */
    public $statuses = array(
        0 => "MODL_USER_STATUS_0",
        1 => "MODL_USER_STATUS_1",
    );

    /**
     * Roles
     * @var array
     */
    public $roles = array(
        1 => "MODL_USER_ROLE_1",
        2 => "MODL_USER_ROLE_2"
    );

    /**
     * Reserved vars (not at database table)
     * @var array
     */
    public static $reservedVarsChild = array("roles", "statuses", "statusesCss");

    /**
     * Class initialization
     *
     * @return void
     */
    public function init()
    {
        parent::$dbTable = "users";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    /**
     * Get the user status
     *
     * @return string User status
     */
    public function getStatusString()
    {
        return $this->statuses[$this->statusId];
    }

    /**
     * Get the CSS class for user status
     *
     * @return string CSS Class
     */
    public function getStatusCssString()
    {
        return $this->statusesCss[$this->statusId];
    }

    /**
     * Get the role of the user
     *
     * @param integer $roleId Role (optional)
     *
     * @return string Role
     */
    public function getRoleString($roleId=0)
    {
        if (!$roleId) {
            $roleId = $this->roleId;
        }
        if ($roleId) {
            return $this->roles[$roleId];
        } else {
            return "-";
        }
    }

    /**
     * Insert and Update validation
     * In this case, its the same for both methods
     *
     * @return bool
     */
    private function validate()
    {
        //Check username already exists
        if (!$this->username) {
            Registry::addMessage(Language::translate("MODL_USER_VALIDATE_USERNAME_EMPTY"), "error", "username");
        } elseif ($this->getBy("username", $this->username, $this->id)) {
            Registry::addMessage(Language::translate("MODL_USER_VALIDATE_USERNAME_TAKEN"), "error", "username");
        }
        //Check email
        if (!$this->email) {
            Registry::addMessage(Language::translate("MODL_USER_VALIDATE_EMAIL_EMPTY"), "error", "email");
        } elseif ($this->getBy("email", $this->email, $this->id)) {
            Registry::addMessage(Language::translate("MODL_USER_VALIDATE_EMAIL_TAKEN"), "error", "email");
        }
        //Password?
        if ($this->password && strlen($this->password)<6) {
            Registry::addMessage(Language::translate("MODL_USER_VALIDATE_PASSWORD_SHORT"), "error", "password");
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
        //Validation
        return $this->validate();
    }

    /**
     * Pre-Insert actions
     *
     * Default language if none was introduced
     * Password encryption
     * Creation date
     * Force role to non-admin
     *
     * @return void
     */
    public function preInsert($data=array())
    {
        $config = Registry::getConfig();
        //Default Language
        if (!$data['language']) {
            $this->language = $config->get("defaultLang");
        }
        //Password encryption
        $this->password = User::encrypt($this->password);
        //Creation Date
        $this->dateInsert = date("Y-m-d H:i:s");
        //Force to non-admin
        $this->roleId = 1;
    }

    /**
     * Update validation
     *
     * @return array Object Messages
     */
    public function validateUpdate()
    {
        //Validation
        return $this->validate();
    }

    /**
     * Pre-Update actions
     *
     * Password encryption
     * Update date
     *
     * @return void
     */
    public function preUpdate($data=array())
    {
        //Prevent blank password override
        if ($data['password']) {
            //Password encryption
            $this->password = User::encrypt($data['password']);
        } else {
            //Empty password to keep the current one
            $this->password = null;
        }
        //Update Date
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    /**
     * Login
     *
     * @param string $login      Username or email
     * @param string $password   Plain password
     * @param int    $expiration Expiration in Seconds
     *
     * @return bool
     */
    public static function login($login, $password, $expiration=7200)
    {
        $db = Registry::getDb();
        $rows = $db->query("SELECT * FROM `users` WHERE (username=:username OR email=:email) AND password=:password",
            array(
                ":email" => $login,
                ":username" => $login,
                ":password" => User::encrypt($password)
            )
        );
        if ($rows) {
            $user = new User($rows[0]);
            //Set Cookie
            $user->token = bin2hex(openssl_random_pseudo_bytes(16));
            $config = Registry::getConfig();
            setcookie($config->get("cookie"), $user->token, time() + $expiration, "/");
            //Update lastVisitDate
            $user->lastvisitDate = date("Y-m-d H:i:s");
            $user->update();

            return $user;
        }
    }

    /**
     * Logout
     *
     * @return bool
     */
    public static function logout()
    {
        $config = Registry::getConfig();
        //Destroy Cookies
        unset($_COOKIE[$config->get("cookie")]);
        setcookie($config->get("cookie"), null, -1, "/");

        return true;
    }

    /**
     * Password encryption
     *
     * @param string $password Plain password
     *
     * @return string Encrypted password
     */
    public static function encrypt($password="")
    {
        return md5(sha1(trim($password)));
    }

    /**
     * Object selection
     *
     * @param array   $data       Conditionals and Order values
     * @param integer $limit      Limit
     * @param integer $limitStart Limit start
     * @param int     $total      Total rows found
     *
     * @return array Objects found
     */
    public static function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `users` WHERE 1=1 ";
        //Total
        $total = count($db->Query($query));
        if ($total) {
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                if (@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".$data['order']."` ".$data['orderDir'];
                }
            }
            //Limit
            if ($limit) {
                $query .= " LIMIT ".(int) $limitStart.", ".(int) $limit;
            }
            $rows = $db->Query($query);
            if (count($rows)) {
                $results = array();
                foreach ($rows as $row) {
                    $results[] = new User($row);
                }

                return $results;
            }
        }
    }

    /**
     * Sends a recovery email to current User
     *
     * @return bool
     */
    public function sendRecovery()
    {
        $this->recoveryHash = bin2hex(openssl_random_pseudo_bytes(16));
        $this->update();
        $mailer = Registry::getMailer();
        $mailer->addAddress($this->email);
        $mailer->Subject = utf8_decode(Language::translate("EMAILS_ACCOUNT_RECOVERY_SUBJECT"));
        $mailer->msgHTML(
            Template::renderEmail(
                "accountRecovery",
                array(
                    "hash" => $this->recoveryHash
                ), "bootstrap"
            )
        );
        if ($mailer->send()) {
            return true;
        } else {
            Registry::addMessage(Language::translate("MODL_USER_RECOVERY_EMAIL_ERROR"), "error");
        }
    }
}
