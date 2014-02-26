<?php
//No direct access
defined('_EXE') or die('Restricted access');

class usersController extends Controller {

	public function init(){
		$user = Registry::getUser();
		if(!$user->id){
			redirect(Url::site("login"));
		}elseif($user->roleId<2){
			redirect(Url::site());
		}
	}

	public function index(){
		$config = Registry::getConfig();
		$pag['total'] = 0;
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		$this->setData("results", User::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']));
		$this->setData("pag", $pag);
		$html = $this->view("views.list");
		$this->render($html);
	}

	public function edit(){
		$url = Registry::getUrl();
		$user = new User($url->vars[0]);
		$this->setData("user", $user);
		$html = $this->view("views.edit");
		$this->render($html);
	}

	public function save(){
		$user = new User($_REQUEST['id']);
		if($user->id){
			$res = $user->update($_REQUEST);
			if($res){
				Registry::addMessage(Registry::translate("CTRL_USERS_UPDATE_OK"), "success", "", Url::site("users"));
			}
		}else{
			$res = $user->insert($_REQUEST);
			if($res){
				Registry::addMessage(Registry::translate("CTRL_USERS_INSERT_OK"), "success", "", Url::site("users"));
			}
		}
		$this->ajax();
	}

	public function delete(){
		$url = Registry::getUrl();
		$user = new User($_REQUEST['id']);
		if($user->id){
			if($user->delete()){
				Registry::addMessage(Registry::translate("CTRL_USERS_DELETE_OK"), "success", "", Url::site("users"));
			}
		}
		$this->ajax();
	}
}
