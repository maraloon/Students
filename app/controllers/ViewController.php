<?php
namespace StudentList\Controllers;
use \StudentList\Helpers\Util;
abstract class ViewController extends Controller{
	protected $module;
	protected $viewName;
	protected $keysOfViewVars=array(); //имена переменных используемые в представлении

	function __construct($viewName,$c){
		parent::__construct($c);
		$this->viewName=$viewName;
	}

	public function parseRequest(){
		if (in_array($this->c['router']->getModule(), $this->validModules)) {
			$this->module=$this->c['router']->getModule();
			$moduleFunc=$this->module.'Module';
			$this->$moduleFunc();
			$this->showView();
		}
	}

	//abstract protected function Module();

	public function showView(){
		$path=array(
				'views'=>'app/views/',
				'css'=>'public/src/style.css'
				);

		foreach ($this->keysOfViewVars as $key){
			$$key=$this->$key;
		}

		//Показываем страницу
		foreach ($path as &$file) {
			$file=Util::getAbsolutePath($file);
		}

		$cssFile=$path['css'];
		include($path['views'].'/modules/header.php');
		include($path['views'].'/'.$this->viewName.'.php');
		include($path['views'].'/modules/footer.php');
	}
}