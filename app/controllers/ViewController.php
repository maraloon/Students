<?php
namespace Project\Controllers;
use \Project\Classes\Util;
abstract class ViewController  extends Controller{
	protected $viewName;
	protected $viewData;

	function __construct($viewName,$c){
		parent::__construct($c);
		$this->viewName=$viewName;
	}

	abstract public function parseRequest();

	public function showView(){
		$path=array(
				'views'=>'app/views/',
				'css'=>'public/src/style.css'
				);
		//распаковываем массив в переменные
		foreach ($this->viewData as $key => $value) {
			$$key=$value;
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