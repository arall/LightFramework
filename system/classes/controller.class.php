<?php

/**
 * Controller Class
 *
 * @package LightFramework\Core
 */
abstract class Controller
{
    /**
     * Stored data to pass throught controller / views
     * @var array
     */
    public $data = array();

    /**
     * Default constructor
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Get the [current] App Path
     *
     * @param  string $app
     * @return string
     */
    public function getPath($app="")
    {
        $config = Registry::getConfig();
        $url = Registry::getUrl();
        if(!$app)
            $app = $url->app;

        return $config->get("path").DIRECTORY_SEPARATOR."apps".DIRECTORY_SEPARATOR.$url->router.DIRECTORY_SEPARATOR.$app.DIRECTORY_SEPARATOR;
    }

    /**
     * Set a value into self data array
     *
     * @param string $name
     * @param mixed  $value
     */
    public function setData($key, $data=null)
    {
        $this->data[$key] = $data;
    }

    /**
     * Loads a view of current App (or the one passed by param)
     *
     * @example view("views.register", "login"); This loads the /apps/login/views/register.view.php file
     *
     * @param  string $view Name of the desired view and its folder
     * @param  string $app
     * @return string HTML view
     */
    public function view($view, $app="")
    {
        $config = Registry::getConfig();

        $template = Registry::getTemplate();
        //Including the controller as data, to enable modules/views inside other views
        $this->data['controller'] = $this;
        $tp = DIRECTORY_SEPARATOR.str_replace(".", DIRECTORY_SEPARATOR, $view).".view";
        //Template priority
        $file = $config->get("path").DIRECTORY_SEPARATOR."templates".DIRECTORY_SEPARATOR.$template->name.$tp;
        if (!file_exists($file.".php")) {
            $path = $this->getPath($app);
            $file = $path.$tp;
        }
        $html = $template->loadTemplate($file, $this->data);

        return $html;
    }

    /**
     * Prints the HTML string passed by param on the current Template
     *
     * @param string $data  HMTL to print
     * @param string $layer Template layer (index.layer.php by default)
     */
    public function render($data, $layer="index")
    {
        $this->data['content'] = $data;
        $this->data['controller'] = $this;
        Template::render($layer, $this->data);
    }

    /**
     * Prints a Json encoded array of data passed by param, or previusly stored messages
     *
     * @param array $data
     */
    final public function ajax($data=array())
    {
        $config = Registry::getConfig();
        $messages = Registry::getMessages();
        //Fix preserve on redirections
        if (count($messages)) {
            foreach ($messages as $message) {
                if ($message->url) {
                    Registry::addMessage($message->message, $message->type, $message->field, $message->url);
                }
            }
        }
        //Custom Data
        $return['data'] = $data;
        //Messages
        $return['messages'] = $messages;
        //Debug messages
        if ($config->get("debug")) {
            $debug = Registry::getDebug();
            if (count($debug['messages'])) {
                foreach ($debug['messages'] as $message) {
                    $return['debug'][] = array(
                        "message" => Helper::printDebugMessage($message['message']),
                        "trace" => "<pre>".print_r($message['trace'], true)."</pre>",
                    );
                }
            }
        }
        echo json_encode($return);
    }
}
