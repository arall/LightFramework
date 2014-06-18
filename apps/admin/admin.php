<?php
//No direct access
defined('_EXE') or die('Restricted access');

class adminControllerRouter extends Controller
{
    public function init()
    {
        //User is admin?
        $user = Registry::getUser();
        if ($user->roleId<2) {
            redirect(Url::site());
        }
    }

    public function index()
    {
        //Redirect to admin/users
        redirect(Url::site("admin/users"));
    }
}
