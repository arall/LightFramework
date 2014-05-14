<?php
class User extends Model
{
    public $id;
    public $statusId;
    public $roleId;
    public $email;
    public $username;
    public $password;
    public $recoveryHash;
    public $language;
    public $dateInsert;
    public $dateUpdate;
    public $lastvisitDate;

    public $statusesCss = array(
        0 => "danger",
        1 => "success",
    );
    public $statuses = array(
        0 => "MODL_USER_STATUS_0",
        1 => "MODL_USER_STATUS_1",
    );
    public $roles = array(
        1 => "MODL_USER_ROLE_1",
        2 => "MODL_USER_ROLE_2"
    );
    public static $reservedVarsChild = array("roles", "statuses", "statusesCss");

    public function init()
    {
        parent::$dbTable = "users";
        parent::$reservedVarsChild = self::$reservedVarsChild;
    }

    public function getStatusString()
    {
        return $this->statuses[$this->statusId];
    }

    public function getStatusCssString()
    {
        return $this->statusesCss[$this->statusId];
    }

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

    public function validateInsert()
    {
        //Check username already exists
        if (!$this->username) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_USERNAME_EMPTY"), "error", "username");
        } elseif ($this->getUserByUsername($this->username)) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_USERNAME_TAKEN"), "error", "username");
        }
        //Check email
        if (!$this->email) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_EMAIL_EMPTY"), "error", "email");
        } elseif ($this->getUserByEmail($this->email)) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_EMAIL_TAKEN"), "error", "email");
        }
        //Password?
        if (!$this->password || strlen($this->password)<6) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_PASSWORD_SHORT"), "error", "password");
        }

        return Registry::getMessages(true);
    }

    public function preInsert($data=array())
    {
        $config = Registry::getConfig();
        //Default Language
        if (!$data['language']) {
            $this->language = $config->get("defaultLang");
        }
        //Passwd encryption
        $this->password = User::encrypt($this->password);
        //Register Date
        $this->dateInsert = date("Y-m-d H:i:s");
        //Force to non-admin
        $this->roleId = 1;
    }

    public function validateUpdate()
    {
        //Check username already exists
        if (!$this->username) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_USERNAME_EMPTY"), "error", "username");
        } elseif ($this->getUserByUsername($this->username, $this->id)) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_USERNAME_TAKEN"), "error", "username");
        }
        //Check email
        if (!$this->email) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_EMAIL_EMPTY"), "error", "email");
        } elseif ($this->getUserByEmail($this->email, $this->id)) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_EMAIL_TAKEN"), "error", "email");
        }
        //Password?
        if ($this->password && strlen($this->password)<6) {
            Registry::addMessage(Registry::translate("MODL_USER_VALIDATE_PASSWORD_SHORT"), "error", "password");
        }

        return Registry::getMessages(true);
    }

    public function preUpdate($data=array())
    {
        //Prevent blank password override
        if ($data['password']) {
            $this->password = User::encrypt($data['password']);
        } else {
            $this->password = null;
        }
        //Update Date
        $this->dateUpdate = date("Y-m-d H:i:s");
    }

    public function login($login, $password)
    {
        $db = Registry::getDb();
        $query = "SELECT * FROM `users` WHERE
        (	`username`='".htmlspecialchars(mysql_real_escape_string(trim($login)))."' OR
            `email`='".htmlspecialchars(mysql_real_escape_string(trim($login)))."'
        ) AND `password`='".User::encrypt($password)."' AND `statusId`=1 LIMIT 1;";
        if ($db->query($query)) {
            if ($db->getNumRows()) {
                $row = $db->fetcharray();
                $user = new User($row);
                //Set Session
                session_start();
                $_SESSION['userId'] = $user->id;
                $_SESSION['lang'] = $user->language;
                //Update lastVisitDate
                $user->lastvisitDate = date("Y-m-d H:i:s");
                $user->update();

                return true;
            }
        }
    }

    public function logout()
    {
        session_start();
        $_SESSION = array();
        session_unset();
        session_destroy();

        return true;
    }

    public function encrypt($password="")
    {
        return md5(sha1(trim($password)));
    }

    public function select($data=array(), $limit=0, $limitStart=0, &$total=null)
    {
        $db = Registry::getDb();
        //Query
        $query = "SELECT * FROM `users` WHERE 1=1 ";
        //Total
        if ($db->Query($query)) {
            $total = $db->getNumRows();
            //Order
            if ($data['order'] && $data['orderDir']) {
                //Secure Field
                $orders = array("ASC", "DESC");
                if (@in_array($data['order'], array_keys(get_class_vars(__CLASS__))) && in_array($data['orderDir'], $orders)) {
                    $query .= " ORDER BY `".mysql_real_escape_string($data['order'])."` ".mysql_real_escape_string($data['orderDir']);
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
                            $results[] = new User($row);
                        }

                        return $results;
                    }
                }
            }
        }
    }

    public function getUserByEmail($email, $ignoreId=0)
    {
        $db = Registry::getDb();
        $query = "SELECT * FROM `users` WHERE `email`='".htmlentities(mysql_real_escape_string($email))."'";
        if ($ignoreId) {
            $query .= " AND `id` !=".(int) $ignoreId;
        }
        if ($db->Query($query)) {
            if ($db->getNumRows()) {
                $row = $db->fetcharray();

                return new User($row);
            }
        }
    }

    public function getUserByUsername($username, $ignoreId=0)
    {
        $db = Registry::getDb();
        $query = "SELECT * FROM `users` WHERE `username`='".htmlentities(mysql_real_escape_string($username))."'";
        if ($ignoreId) {
            $query .= " AND `id` !=".(int) $ignoreId;
        }
        if ($db->Query($query)) {
            if ($db->getNumRows()) {
                $row = $db->fetcharray();

                return new User($row);
            }
        }
    }

    public function getUserByRecoveryHash($hash)
    {
        $db = Registry::getDb();
        $query = "SELECT * FROM `users` WHERE `recoveryHash`='".htmlentities(mysql_real_escape_string($hash))."'";
        if ($db->Query($query)) {
            if ($db->getNumRows()) {
                $row = $db->fetcharray();

                return new User($row);
            }
        }
    }

    public function sendRecovery()
    {
        $this->recoveryHash = bin2hex(openssl_random_pseudo_bytes(16));
        $this->update();
        $mailer = Registry::getMailer();
        $mailer->addAddress($this->email);
        $mailer->Subject = utf8_decode(Registry::translate("EMAILS_ACCOUNT_RECOVERY_SUBJECT"));
        $mailer->msgHTML(
            Template::renderEmail(
                "accountRecovery",
                array(
                    "hash" => $this->recoveryHash
                ), "bootstrap"
            )
        );
        $mailer->send();
    }
}
