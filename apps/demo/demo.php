<?php
//No direct access
defined('_EXE') or die('Restricted access');

class demoController extends Controller {
	
	public function init(){
	}
	
	public function index(){
		//Get Data from Model
		$demos = Demo::selectDemos();
		//Set Data to view
		$this->setData("title", "First Select");
		$this->setData("demos", $demos);
		//Load View to Template var
		$html .= $this->view("views.test");
		//Update Demos from Model
		if(count($demos)){
			foreach($demos as $demo){
				//print_pre($demo);
				$demo->update();
			}
		}
		//Set Data again to view
		$this->setData("title", "Second Select");
		$this->setData("demos", $demos);
		//Load View to Template var
		$html .= $this->view("views.test");
		//Render the Template
		$this->render($html);
	}
}
?>