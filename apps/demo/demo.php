<?php
// No direct access
defined('_EXE') or die('Restricted access');

/**
 * Demo Controller
 */
class demoController extends Controller
{
    /**
     * Init
     */
    public function init()
    {
        $user = Registry::getUser();

        // User must be logged
        if (!$user->id) {
            Url::redirect(Url::site("login"));
        }
    }

    /**
     * Default list view
     */
    public function index()
    {
        $config = Registry::getConfig();

        // Pagination
        $pag = array();

        // Total
        $pag['total'] = 0;

        // Limit
        $pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
        $pag['limitStart'] = $_REQUEST['limitStart'];

        // Demo Select
        $results = Demo::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']);

        // Setting data to View
        $this->setData("results", $results);
        $this->setData("pag", $pag);

        // Load View to Template var
        $html = $this->view("views.list");

        // Render the Template
        $this->render($html);
    }

    /**
     * Edit form view
     */
    public function edit()
    {
        $url = Registry::getUrl();

        // Load demo to view
        $this->setData("demo", new Demo($url->vars[0]));

        // Load View to Template var
        $html = $this->view("views.edit");

        // Render the Template
        $this->render($html);
    }

    /**
     * Save action
     */
    public function save()
    {
        // Get demo
        $demo = new Demo($_REQUEST['id']);

        // Editing
        if ($demo->id) {
            // Update Demo
            if ($demo->update($_REQUEST)) {
                // Add success message
                Registry::addMessage(Language::translate("CTRL_DEMO_UPDATE_OK"), "success", "", Url::site("demo"));
            }
        // Creating
        } else {
            // Insert Demo
            if ($demo->insert($_REQUEST)) {
                // Add success message
                Registry::addMessage(Language::translate("CTRL_DEMO_INSERT_OK"), "success", "", Url::site("demo"));
            }
        }

        // Show ajax JSON response
        $this->ajax();
    }

    /**
     * Delete action
     */
    public function delete()
    {
        $url = Registry::getUrl();

        // Get demo
        $demo = new Demo($url->vars[0]);

        // Demo exist?
        if ($demo->id) {
            // Delete Demo
            if ($demo->delete()) {
                // Add success message
                Registry::addMessage(Language::translate("CTRL_DEMO_DELETE_OK"), "success");
            }
        }

        // Redirect
        Url::redirect(Url::site("demo"));
    }
}
