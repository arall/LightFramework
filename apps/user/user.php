<?php
//No direct access
defined('_EXE') or die('Restricted access');

class userController extends Controller {
	
	public function init(){
	}
	
	public function index(){
		$this->register();
	}

	public function register(){

	}

	public function login(){
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
			Registry::addMessage("Login incorrect", "error", "login");
		}
		//Do not render the template, just ajax (Messages)
		$this->ajax();
	}

	public function logout(){
		User::logout();
		redirect(Url::site());
	}
}
?>