<?php
//No direct access
defined('_EXE') or die('Restricted access');

class loginController extends Controller {

	public function init(){
	}

	public function index(){
		$this->login();
	}

	public function register(){
		//Load View to Template
		$html .= $this->view("views.register");
		//Render the Template
		$this->render($html);
	}

	public function doRegister(){
		//Try to register
		$user = new User();
		$res = $user->insert($_REQUEST);
		//If login its ok...
		if($res==true){
			//Do first login
			$user->login($_REQUEST['username'], $_REQUEST['password']);
			//Redirect to main page thought Message URL parameter
			Registry::addMessage("", "", "", Url::site());
		}
		//Do not render the template, just ajax (Messages)
		$this->ajax();
	}

	public function login(){
		//Load View to Template
		$html .= $this->view("views.login");
		//Render the Template
		$this->render($html);
	}

	public function doLogin(){
		//Try to login
		$user = new User();
		$res = $user->login($_REQUEST['login'], $_REQUEST['password']);
		//If login its ok...
		if($res==true){
			//Redirect to main page thought Message URL parameter
			Registry::addMessage("", "", "", Url::site());
		//If not...
		}else{
			//Create message
			Registry::addMessage(Registry::translate("CTRL_LOGIN_LOGIN_ERROR"), "error", "login");
		}
		//Do not render the template, just ajax (Messages)
		$this->ajax();
	}

	public function doLogout(){
		User::logout();
		redirect(Url::site());
	}
}
