<?php
namespace StudentList\Controllers;
use \StudentList\Helpers\Util;
abstract class ViewController extends Controller{
	protected $viewName;

	function __construct($c){
		parent::__construct($c);
		$this->viewName=$c['action'];
	}

	public function showView(){
		extract($this->ViewVars);
		include(Util::getAbsolutePath('app/views/pages/index.php'));
	}
}