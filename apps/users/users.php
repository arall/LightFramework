<?php
//No direct access
defined('_EXE') or die('Restricted access');

/**
 * Users Controller
 */
class usersController extends Controller
{
    /**
     * Init
     */
    public function init()
    {

        $user = Registry::getUser();
        //User must be logged
        if (!$user->id) {
            redirect(Url::site("login"));
        //User must be admin
        } elseif ($user->roleId<2) {
            redirect(Url::site());
        }
    }

    /**
     * Default list view
     */
    public function index()
    {
        $config = Registry::getConfig();
        //Pagination
        $pag = array();
        //Total
        $pag['total'] = 0;
        //Limit
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];
        //Users Select
        $this->setData("results", User::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
        //Setting data to View
        $this->setData("pag", $pag);
        //Load View to Template var
        $html = $this->view("views.list");
        //Render the Template
        $this->render($html);
    }

    /**
     * Edit form view
     */
    public function edit()
    {
        $url = Registry::getUrl();
        $this->setData("user", new User($url->vars[0]));
        //Load View to Template var
        $html = $this->view("views.edit");
        //Render the Template
        $this->render($html);
    }

    /**
     * Save action
     */
    public function save()
    {
        $user = new User($_REQUEST['id']);
        //Editing
        if ($user->id) {
            //Update User
            if ($user->update($_REQUEST)) {
                //Add success message
                Registry::addMessage(Registry::translate("CTRL_USERS_UPDATE_OK"), "success", "", Url::site("users"));
            }
        //Creating
        } else {
            //Insert User
            if ($user->insert($_REQUEST)) {
                //Add success message
                Registry::addMessage(Registry::translate("CTRL_USERS_INSERT_OK"), "success", "", Url::site("users"));
            }
        }
        //Show ajax JSON response
        $this->ajax();
    }

    /**
     * Delete action
     */
    public function delete()
    {
        $user = new User($_REQUEST['id']);
        if ($user->id) {
            //Delete User
            if ($user->delete()) {
                //Add success message
                Registry::addMessage(Registry::translate("CTRL_USERS_DELETE_OK"), "success", "", Url::site("users"));
            }
        }
        //Show ajax JSON response
        $this->ajax();
    }
}
