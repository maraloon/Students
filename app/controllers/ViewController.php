<?php
namespace StudentList\Controllers;
use \StudentList\Helpers\Util;
abstract class ViewController extends Controller{
	protected $module;
	protected $viewName;

	function __construct($c){
		parent::__construct($c);
		$this->viewName=$c['module'];
	}

	public function showView(){
		extract($this->ViewVars);
		include(Util::getAbsolutePath('app/views/pages/index.php'));
	}
}