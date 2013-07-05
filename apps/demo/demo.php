<?php
//No direct access
defined('_EXE') or die('Restricted access');

class demoController extends Controller {
	
	public function init(){
	}
	
	public function index(){
		//Get Data
		$demos = Demo::selectDemos();
		//Set Data
		$this->setData("title", "First Select");
		$this->setData("demos", $demos);
		//Load View
		$html .= $this->view("views.test");
		//Update Demos
		if(count($demos)){
			foreach($demos as $demo){
				//print_pre($demo);
				$demo->update();
			}
		}
		//Set Data again
		$this->setData("title", "Second Select");
		$this->setData("demos", $demos);
		//Load View
		$html .= $this->view("views.test");
		//Show View
		$this->render($html);
	}
}
?>