<?php
//No direct access
defined('_EXE') or die('Restricted access');

/**
 * User login Controller
 */
class loginController extends Controller
{
    /**
     * Init
     */
    public function init() {}

    /**
     * Default view
     */
    public function index()
    {
        //Load Login form view
        $this->login();
    }

    /**
     * Login form view
     */
    public function login()
    {
        //Load View to Template var
        $html = $this->view("views.login");
        //Render the Template
        $this->render($html);
    }

    /**
     * Recovery form view
     */
    public function recovery()
    {
        //Load View to Template var
        $html = $this->view("views.recovery");
        //Render the Template
        $this->render($html);
    }

    /**
     * Recovery action
     */
    public function sendRecovery()
    {
        $user = current(User::getBy("email", $_REQUEST['email']));
        //User exists?
        if ($user->id) {
            //Send recovery email
            if ($user->sendRecovery()) {
                //Add success message
                Registry::addMessage(Language::translate("CTRL_LOGIN_RECOVERY_EMAIL_SENT"), "success");
            }
        }
        //Redirect to index
        Url::redirect(Url::site());
    }

    /**
     * Restore account form view
     */
    public function restore()
    {
        $url = Registry::getUrl();
        $user = current(User::getBy("recoveryHash", $url->vars[0]));
        //User exists?
        if ($user->id) {
            //Setting data to View
            $this->setData("user", $user);
            //Load View to Template var
            $html = $this->view("views.restore");
            //Render the Template
            $this->render($html);
        } else {
            //Redirect to index
            Url::redirect(Url::site());
        }
    }

    /**
     * Restore account action
     */
    public function changePassword()
    {
        $user = current(User::getBy("recoveryHash", $_REQUEST["recoveryHash"]));
        //User exists?
        if ($user->id) {
            //Check if passwords match
            if ($_REQUEST['password']==$_REQUEST['password2']) {
                //Empty the Recovery Hash
                $user->recoveryHash = "";
                //Update User
                $user->update($_REQUEST);
                //Login
                $user->login($user->email, $_REQUEST['password']);
                //Add success message
                Registry::addMessage(Language::translate("CTRL_LOGIN_PASSWORD_CHANGED_OK"), "success", "", Url::site());
            //Passwords does't match
            } else {
                //Add error message
                Registry::addMessage(Language::translate("CTRL_LOGIN_PASSWORDS_DOESNT_MATCH"), "error", "password");
            }
        }
        //Show ajax JSON response
        $this->ajax();
    }

    /**
     * Login action
     */
    public function doLogin()
    {
        $user = new User();
        //Try to login
        if ($user->login($_REQUEST['login'], $_REQUEST['password'])) {
            //Add success message
            Registry::addMessage("", "", "", Url::site());
        } else {
            //Add error message and redirect to login form view
            Registry::addMessage(Language::translate("CTRL_LOGIN_LOGIN_ERROR"), "error", "login");
        }
        //Show ajax JSON response
        $this->ajax();
    }

    /**
     * Logout action
     */
    public function doLogout()
    {
        $user = new User();
        //Logout
        $user->logout();
        //Redirect to index
        Url::redirect(Url::site());
    }

    /**
     * Register form view
     */
    public function register()
    {
        //Load View to Template var
        $html = $this->view("views.register");
        //Render the Template
        $this->render($html);
    }

    /**
     * Register action
     */
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
        //Show ajax JSON response
        $this->ajax();
    }
}
