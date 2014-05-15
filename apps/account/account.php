<?php
//No direct access
defined('_EXE') or die('Restricted access');

class accountController extends Controller
{
    public function init()
    {
        $user = Registry::getUser();
        if (!$user->id) {
            redirect(Url::site("login"));
        }
    }

    public function index()
    {
        $this->edit();
    }

    public function edit()
    {
        $html = $this->view("views.edit");
        $this->render($html);
    }

    public function save()
    {
        $user = Registry::getUser();
        //Prevent role escalation
        $_REQUEST['roleId'] = $user->roleId;
        //Prevent status change
        $_REQUEST['statusId'] = $user->statusId;
        if ($user->update($_REQUEST)) {
            Registry::addMessage(Registry::translate("CTRL_ACCOUNT_UPDATE_OK"), "success", "", Url::site());
        }
        $this->ajax();
    }
}
