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
		//Get Data from Model
		$total = Demo::getTotalDemos();
		$this->setData("total", $total);
		$demo = Demo::getLastDemo();
		$this->setData("demo", $demo);
		//Load View to Template var
		$html .= $this->view("views.test");
		//Render the Template
		$this->render($html);
	}

	public function generate(){
		$demo = new Demo();
		$demo->insert();
		redirect(Url::site("demo"));
	}
}
