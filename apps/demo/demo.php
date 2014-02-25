<?php
//No direct access
defined('_EXE') or die('Restricted access');

class demoController extends Controller {

	public function init(){
		//Must be logged
		$user = Registry::getUser();
		if(!$user->id){
			redirect(Url::site("login"));
		}
	}

	public function index(){
		//This is a simple Debug Message
		Registry::addDebugMessage("Sample debug message");
		$config = Registry::getConfig();
		//Total
		$pag['total'] = 0;
		//Limit
		$pag['limit'] = $_REQUEST['limit'] ? $_REQUEST['limit'] : $config->get("defaultLimit");
		$pag['limitStart'] = $_REQUEST['limitStart'];
		//Demo Select
		$results = Demo::select($_REQUEST, $pag['limit'], $pag['limitStart'], $pag['total']);
		//Setting data to View
		$this->setData("results", $results);
		$this->setData("pag", $pag);
		//Load View to Template var
		$html = $this->view("views.list");
		//Render the Template
		$this->render($html);
	}

	public function edit(){
		$url = Registry::getUrl();
		$demo = new Demo($url->vars[0]);
		$this->setData("demo", $demo);
		//Load View to Template var
		$html = $this->view("views.edit");
		//Render the Template
		$this->render($html);
	}

	public function save(){
		$demo = new Demo($_REQUEST['id']);
		if($demo->id){
			$res = $demo->update($_REQUEST);
			if($res){
				Registry::addMessage(Registry::translate("CTRL_DEMO_UPDATE_OK"), "success", "", Url::site("demo"));
			}
		}else{
			$res = $demo->insert($_REQUEST);
			if($res){
				Registry::addMessage(Registry::translate("CTRL_DEMO_INSERT_OK"), "success", "", Url::site("demo"));
			}
		}
		$this->ajax();
	}

	public function delete(){
		$url = Registry::getUrl();
		$demo = new Demo($_REQUEST['id']);
		if($demo->id){
			$res = $demo->delete();
			if($res){
				Registry::addMessage(Registry::translate("CTRL_DEMO_DELETE_OK"), "success", "", Url::site("demo"));
			}
		}
		$this->ajax();
	}
}
