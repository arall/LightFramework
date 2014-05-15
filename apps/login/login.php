<?php
//No direct access
defined('_EXE') or die('Restricted access');

class loginController extends Controller
{
    public function init() {}

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        $html = $this->view("views.login");
        $this->render($html);
    }

    public function recovery()
    {
        $html = $this->view("views.recovery");
        $this->render($html);
    }

    public function sendRecovery()
    {
        $user = User::getUserByEmail($_REQUEST['email']);
        if ($user->id) {
            $user->sendRecovery();
            Registry::addMessage(Registry::translate("CTRL_LOGIN_RECOVERY_EMAIL_SENT"), "success");
        }
        redirect(Url::site());
    }

    public function restore()
    {
        $url = Registry::getUrl();
        $user = User::getUserByRecoveryHash($url->vars[0]);
        if ($user->id) {
            $this->setData("user", $user);
            $html = $this->view("views.restore");
            $this->render($html);
        } else {
            redirect(Url::site());
        }
    }

    public function changePassword()
    {
        $url = Registry::getUrl();
        $user = User::getUserByRecoveryHash($_REQUEST["recoveryHash"]);
        if ($user->id) {
            if ($_REQUEST['password']==$_REQUEST['password2']) {
                $user->recoveryHash = "";
                $user->update($_REQUEST);
                $user->login($user->email, $_REQUEST['password']);
                Registry::addMessage(Registry::translate("CTRL_LOGIN_PASSWORD_CHANGED_OK"), "success", "", Url::site());
            } else {
                Registry::addMessage(Registry::translate("CTRL_LOGIN_PASSWORDS_DOESNT_MATCH"), "error", "password");
            }
        }
        $this->ajax();
    }

    public function doLogin()
    {
        $user = new User();
        $res = $user->login($_REQUEST['login'], $_REQUEST['password']);
        if ($res==true) {
            Registry::addMessage("", "", "", Url::site());
        } else {
            Registry::addMessage(Registry::translate("CTRL_LOGIN_LOGIN_ERROR"), "error", "login");
        }
        $this->ajax();
    }

    public function doLogout()
    {
        $user = new User();
        $user->logout();
        redirect(Url::site());
    }

    public function register()
    {
        //Load View to Template
        $html = $this->view("views.register");
        //Render the Template
        $this->render($html);
    }

    public function doRegister()
    {
        //Try to register
        $user = new User();
        //Force enable account
        $_REQUEST['statusId'] = 1;
        if ($user->insert($_REQUEST)) {
            //Do first login
            $user->login($_REQUEST['username'], $_REQUEST['password']);
            //Redirect to main page thought Message URL parameter
            Registry::addMessage("", "", "", Url::site());
        }
        //Do not render the template, just ajax (Messages)
        $this->ajax();
    }
}
