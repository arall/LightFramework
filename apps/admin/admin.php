<?php
//No direct access
defined('_EXE') or die('Restricted access');

class adminControllerRouter extends ControllerRouter
{
    public function init()
    {
        //User is admin?
        $user = Registry::getUser();
        if ($user->roleId<2) {
            Url::redirect();
        }
    }

    public function index()
    {
        //Redirect to admin/users
        Url::redirect(Url::site("admin/users"));
    }
}
